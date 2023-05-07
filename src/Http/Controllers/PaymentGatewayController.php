<?php

namespace Kevariable\Psr11\Http\Controllers;

class PaymentGatewayController
{
    public function create(): string
    {
        return '<form method="post" action="/payment-gateway">
             <label>Email</label>
             <input type="email" name="email" />
        </form>';
    }

    public function store(): void
    {
        var_dump($_POST);
    }
}