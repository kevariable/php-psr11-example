<?php

namespace Kevariable\Psr11\PaymentMethod\Contracts;

interface Gateway
{
    public function notify(array $data): void;
}