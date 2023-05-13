<?php

use Kevariable\Psr11\Foundation\Application;
use Kevariable\Psr11\Http\Controllers\HomeController;
use Kevariable\Psr11\Http\Controllers\PaymentGatewayController;
use Kevariable\Psr11\Router\Data\ResolveData;
use Kevariable\Psr11\Router\Router;

require __DIR__.'/../vendor/autoload.php';

$router = new Router;

$router
    ->get(path: '/foo', action: HomeController::class)
    ->get(path: '/payment-gateway', action: [PaymentGatewayController::class, 'create'])
    ->get(path: '/bar', action: function (): void {
        echo 'From bar';
    })
    ->post(path: '/payment-gateway', action: [PaymentGatewayController::class, 'store']);


$app = new Application($router);

$app->boot(data: new ResolveData(
    uri: $_SERVER['REQUEST_URI'],
    method: $_SERVER['REQUEST_METHOD']
));
