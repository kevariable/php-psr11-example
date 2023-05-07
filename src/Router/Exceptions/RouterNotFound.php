<?php

namespace Kevariable\Psr11\Router\Exceptions;

class RouterNotFound extends \Exception
{
    public function __construct(string $path)
    {
        parent::__construct(
            message: 'Path of '. $path .' not found',
            code: 404,
        );
    }
}