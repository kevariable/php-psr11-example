<?php

namespace Kevariable\Psr11\Http\Controllers;

use Kevariable\Psr11\PaymentMethod\Stripe;

class HomeController
{
    public function __construct(
        public Stripe $stripe
    ) {
    }

    public function __invoke(): void
    {
        $this->stripe->notify(['foo' => 'bar']);
    }
}