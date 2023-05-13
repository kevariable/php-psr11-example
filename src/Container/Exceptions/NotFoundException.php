<?php

namespace Kevariable\Psr11\Container\Exceptions;


use Psr\Container\NotFoundExceptionInterface;

class NotFoundException extends \Exception implements NotFoundExceptionInterface
{
}