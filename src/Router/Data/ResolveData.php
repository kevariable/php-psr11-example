<?php

namespace Kevariable\Psr11\Router\Data;

final readonly class ResolveData
{
    public function __construct(
        public string $uri,
        public string $method,
    ) {
    }
}