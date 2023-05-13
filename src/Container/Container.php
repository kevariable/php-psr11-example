<?php

namespace Kevariable\Psr11\Container;

use Illuminate\Support\Arr;
use Kevariable\Psr11\Container\Exceptions\ContainerException;
use Kevariable\Psr11\Container\Exceptions\NotFoundException;
use Kevariable\Psr11\Container\Exceptions\ParameterBuiltinTypeDoesNotSupportedException;
use Kevariable\Psr11\Container\Exceptions\ParameterDoesNotHaveTypeException;
use Kevariable\Psr11\Container\Exceptions\ParameterUnionTypeDoesNotSupportedException;
use Psr\Container\ContainerInterface;
use ReflectionException;

class Container implements ContainerInterface
{
    public array $entries = [];

    /**
     * @throws ReflectionException
     * @throws ContainerException
     */
    public function get(string $id): mixed
    {
        if ($this->has($id)) {
            $concrete = $this->entries[$id];

            return $concrete($this);
        }

        return $this->resolve($id);
    }

    /**
     * @throws ReflectionException
     * @throws ContainerException
     */
    protected function resolve(string $id): mixed
    {
        $reflection = new \ReflectionClass($id);

        if (! $reflection->isInstantiable()) {
            throw new ContainerException();
        }

        $constructor = $reflection->getConstructor();

        if (! $constructor) {
            return new $id;
        }

        $parameters = $constructor->getParameters();

        if (! $parameters) {
            return new $id;
        }

        $dependencies = Arr::map(
            $parameters,
            function (\ReflectionParameter $parameter) {
                if (! $parameter->getType()) {
                    throw new ParameterDoesNotHaveTypeException();
                }

                if ($parameter->getType() instanceof \ReflectionUnionType) {
                    throw new ParameterUnionTypeDoesNotSupportedException();
                }

                if ($parameter->getType() instanceof \ReflectionNamedType && $parameter->getType()->isBuiltin()) {
                    throw new ParameterBuiltinTypeDoesNotSupportedException();
                }

                if ($parameter->getType() instanceof \ReflectionNamedType && ! $parameter->getType()->isBuiltin()) {
                    return $this->get($parameter->getType()->getName());
                }

                throw new ContainerException();
            }
        );

        return $reflection->newInstanceArgs($dependencies);
    }

    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    public function bind(string $abstract, \Closure $concrete): self
    {
        $this->entries[$abstract] = $concrete;

        return $this;
    }
}