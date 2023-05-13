<?php

namespace Tests\Fixture\Container;

use Kevariable\Psr11\PaymentMethod\Stripe;
use Tests\Fixture\Container\Notification;

final class BuiltinType
{
    public function __construct(
        public string $notification
    ) {
    }
}