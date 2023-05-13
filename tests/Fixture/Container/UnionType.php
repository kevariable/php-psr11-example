<?php

namespace Tests\Fixture\Container;

use Kevariable\Psr11\PaymentMethod\Paddle;
use Kevariable\Psr11\PaymentMethod\Stripe;

final readonly class UnionType
{
    public function __construct(
        public Stripe | Paddle $gateway,
    ) {
    }

    public function process(): void
    {
        $this->gateway->notify([]);
    }
}