<?php

namespace Kevariable\Psr11\Router;

use Kevariable\Psr11\Container\Container;
use Kevariable\Psr11\Container\Exceptions\ContainerException;
use Kevariable\Psr11\Router\Data\ResolveData;
use Kevariable\Psr11\Router\Exceptions\ActionNotFound;
use Kevariable\Psr11\Router\Exceptions\RouterNotFound;
use ReflectionException;

class Router
{
    private array $routes = [];

    public function __construct(public Container $container)
    {
    }

    protected function register(string $path, string | array | \Closure $action, string $method): self
    {
        $this->routes[$method][$path] = $action;

        return $this;
    }

    public function get(string $path, string | array | \Closure $action): self
    {
        return $this->register(path: $path, action: $action, method: 'GET');
    }

    public function post(string $path, string | array | \Closure $action): self
    {
        return $this->register(path: $path, action: $action, method: 'POST');
    }

    public function routes(): array
    {
        return $this->routes;
    }

    public function getAction(string $path, string $method): string | array | \Closure | false
    {
        return $this->routes[$method][$path] ?? false;
    }

    /**
     * @throws ActionNotFound
     * @throws ContainerException
     * @throws ReflectionException
     * @throws RouterNotFound
     * @param ResolveData $data
     * @return mixed
     */
    public function resolve(ResolveData $data): mixed
    {
        $url = parse_url($data->uri);

        $path = $url['path'];

        $action = $this->getAction(path: $path, method: $data->method);

        if (! $action) {
            throw new RouterNotFound($path);
        }

        return match (true) {
            is_string($action) => call_user_func($this->container->get($action)),
            is_callable($action) => call_user_func($action),
            is_array($action) => $this->resolveArray($action)
        };
    }

    /**
     * @throws ActionNotFound
     * @throws ContainerException
     * @throws ReflectionException
     * @return mixed
     * @param array $action
     */
    protected function resolveArray(array $action): mixed
    {
        [$class, $method] = $action;

        if (! class_exists(class: $class)) {
            throw new ActionNotFound($class);
        }

        if (! method_exists($class, $method)) {
            throw new ActionNotFound($class, $method);
        }

        return call_user_func_array([$this->container->get($class), $method], []);
    }
}