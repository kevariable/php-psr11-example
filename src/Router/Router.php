<?php

namespace Kevariable\Psr11\Router;

use Kevariable\Psr11\Router\Exceptions\ActionNotFound;
use Kevariable\Psr11\Router\Exceptions\RouterNotFound;

class Router
{
    private array $routes = [];

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
     * @throws RouterNotFound
     * @return mixed
     * @param string $uri
     * @param string $method
     */
    public function resolve(string $uri, string $method): mixed
    {
        $url = parse_url($uri);

        $path = $url['path'];

        $action = $this->getAction(path: $path, method: $method);

        if (! $action) {
            throw new RouterNotFound($path);
        }

        return match (true) {
            is_string($action) => call_user_func(new $action),
            is_callable($action) => call_user_func($action),
            is_array($action) => $this->resolveArray($action)
        };
    }

    /**
     * @throws ActionNotFound
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

        return call_user_func_array([new $class, $method], []);
    }
}