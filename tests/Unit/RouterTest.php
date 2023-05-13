<?php

use Kevariable\Psr11\Router\Data\ResolveData;
use Kevariable\Psr11\Router\Exceptions\RouterNotFound;
use Kevariable\Psr11\Router\Router;

beforeEach()
    ->with(fn () => [
        new Router()
    ]);

it(description: 'can registers a get route')
    ->group('router')
    ->defer(callable: function (Router $router) {
        $router->get(path: '/foo', action: 'Foo');
        $router->get(path: '/bar', action: 'Bar');

        expect($router->routes())
            ->toBe(expected: [
                'GET' => [
                    '/foo' => 'Foo',
                    '/bar' => 'Bar',
                ]
            ]);
    });

it(description: 'can registers a post route')
    ->group('router')
    ->defer(callable: function (Router $router) {
        $router->post(path: '/foo', action: 'Foo');
        $router->post(path: '/bar', action: 'Bar');

        expect($router->routes())
            ->toBe(expected: [
                'POST' => [
                    '/foo' => 'Foo',
                    '/bar' => 'Bar',
                ]
            ]);
    });

it(description: 'can registers a post and get route')
    ->group('router')
    ->defer(callable: function (Router $router) {
        $router->post(path: '/foo', action: 'Foo');
        $router->post(path: '/bar', action: 'Bar');

        $router->get(path: '/foo', action: 'Foo');
        $router->get(path: '/bar', action: 'Bar');

        expect($router->routes())
            ->toBe(expected: [
                'POST' => [
                    '/foo' => 'Foo',
                    '/bar' => 'Bar',
                ],
                'GET' => [
                    '/foo' => 'Foo',
                    '/bar' => 'Bar',
                ]
            ]);
    });

it(description: 'routes is not available when router is created')
    ->group('router')
    ->defer(
        callable: fn (Router $router) => expect($router->routes())->toBeEmpty()
    );

it(description: 'can resolve route from callable')
    ->group('router')
    ->defer(callable: function (Router $router) {
        $router->get(path: '/foo', action: fn () => true);

        expect($router->resolve(new ResolveData(uri: '/foo', method: 'GET')))
            ->toBeTrue();
    });

it(description: 'can resolve route from array')
    ->group('router')
    ->defer(function (Router $router) {
        $action = new class {
            public function create(): bool
            {
                return true;
            }
        };

        $router->get(path: '/foo', action: [$action::class, 'create']);

        expect($router->resolve(new ResolveData(uri: '/foo', method: 'GET')))->toBeTrue();
    });

it(description: 'can resolve route from string')
    ->group('router')
    ->defer(function (Router $router) {
        $action = new class {
            public function __invoke(): bool
            {
                return true;
            }
        };

        $router->get(path: '/foo', action: $action::class);

        expect($router->resolve(new ResolveData(uri: '/foo', method: 'GET')))->toBeTrue();
    });

it(description: 'throws route not found exception')
    ->group('router')
    ->with(fn () => [
        ['/foo', 'GET'],
        ['/foo', 'POST'],
    ])
    ->throws(exception: RouterNotFound::class)
    ->defer(callable: function (Router $router, string $uri, string $method) {
        $action = new class {};

        $router->get(path: '/bar', action: [$action::class, 'create']);

        $router->resolve(new ResolveData(uri: $uri, method: $method));
    });