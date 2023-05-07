<?php

namespace Kevariable\Psr11\Router\Exceptions;

class ActionNotFound extends \Exception
{
    public function __construct(string $action, string | null $method = null)
    {
        parent::__construct(
            message: match (true) {
                is_null($method) => 'Action '. $action .' not found',
                default => 'Action '. $action . ' and method '. $method .' not found'
            },
            code: 404,
        );
    }
}