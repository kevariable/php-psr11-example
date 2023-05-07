<?php

namespace Kevariable\Psr11\Http\Controllers;

class HomeController
{
    public function __invoke(): void
    {
        echo 'Foo';
    }
}