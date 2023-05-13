<?php

namespace Kevariable\Psr11\Foundation;

use Kevariable\Psr11\Container\Container;
use Kevariable\Psr11\Router\Data\ResolveData;
use Kevariable\Psr11\Router\Router;

class Application
{
    public function __construct(
        protected Router $router,
        protected Container $container = new Container
    ) {
    }

    public function boot(ResolveData $data): self
    {
        try {
            echo $this->router->resolve($data);
        } catch (\Throwable $e) {
            echo $e->getMessage();
        }

        return $this;
    }
}