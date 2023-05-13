<?php

use Kevariable\Psr11\Container\Exceptions\ParameterBuiltinTypeDoesNotSupportedException;
use Tests\Fixture\Container\BuiltinType;
use Tests\Fixture\Container\NonType;
use Kevariable\Psr11\Container\Exceptions\ParameterDoesNotHaveTypeException;
use Tests\Fixture\Container\UnionType;
use Kevariable\Psr11\Container\Exceptions\ParameterUnionTypeDoesNotSupportedException;
use Tests\Fixture\Container\NamedType;
use Kevariable\Psr11\Container\Container;
use Kevariable\Psr11\PaymentMethod\Contracts\Gateway;
use Kevariable\Psr11\PaymentMethod\Stripe;

beforeEach()
    ->with(
        fn () => [
            new Container()
        ]
    );

it(description: 'can register bind class')
    ->group('container')
    ->defer(callable: function (Container $container) {
        $container->bind(Stripe::class, fn () => new Stripe());

        expect($container->get(Stripe::class))
            ->toBeInstanceOf(class: Stripe::class);
    });

it(description: 'can resolve class')
    ->group('container')
    ->defer(callable: function (Container $container) {
        expect($container->get(Stripe::class))
            ->toBeInstanceOf(class: Stripe::class);
    });

it(description: 'can nested resolve class')
    ->group('container')
    ->defer(callable: function (Container $container) {
        expect($container->get(NamedType::class))
            ->toBeInstanceOf(class: NamedType::class);
    });

it (description: 'can\'t resolve union type')
    ->group('container')
    ->throws(exception: ParameterUnionTypeDoesNotSupportedException::class)
    ->defer(callable: fn (Container $container) => $container->get(UnionType::class));

it (description: 'can\'t resolve non type')
    ->group('container')
    ->throws(exception: ParameterDoesNotHaveTypeException::class)
    ->defer(callable: fn (Container $container) => $container->get(NonType::class));

it (description: 'can\'t resolve primitive type')
    ->group('container')
    ->throws(exception: ParameterBuiltinTypeDoesNotSupportedException::class)
    ->defer(callable: fn (Container $container) => $container->get(BuiltinType::class));