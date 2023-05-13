<?php

namespace Tests\Fixture\Router;

use Kevariable\Psr11\PaymentMethod\Stripe;
use Tests\Fixture\Container\Notification;

final readonly class NamedTypeController
{
    public function __construct(
        public Stripe $stripe,
        public Notification $notification
    ) {
    }

    public function __invoke(): false
    {
        return false;
    }
}