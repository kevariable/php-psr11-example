<?php

namespace Tests\Fixture\Container;

use Kevariable\Psr11\PaymentMethod\Stripe;
use Tests\Fixture\Container\Notification;

final class NonType
{
    public function __construct(
        public $notification
    ) {
    }
}