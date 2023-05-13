<?php

namespace Kevariable\Psr11\PaymentMethod;

use Kevariable\Psr11\PaymentMethod\Contracts\Gateway;

class Paddle implements Gateway
{
    public function notify(array $data): void
    {
        echo 'From Paddle';
    }
}