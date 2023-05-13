<?php

namespace Kevariable\Psr11\PaymentMethod;

use Kevariable\Psr11\PaymentMethod\Contracts\Gateway;

class Stripe implements Gateway
{
    public function notify(array $data): void
    {
        echo 'From Stripe';
    }
}