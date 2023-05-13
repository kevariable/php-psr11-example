<?php

namespace Tests\Fixture\Container;

use Kevariable\Psr11\PaymentMethod\Stripe;

final readonly class NamedType
{
    public function __construct(
        public Stripe $stripe,
        public Notification $notification
    ) {
    }
}