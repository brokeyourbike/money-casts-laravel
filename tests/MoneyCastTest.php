<?php

// Copyright (C) 2021 Ivan Stasiuk <brokeyourbike@gmail.com>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\MoneyCasts\Tests;

use PHPUnit\Framework\TestCase;
use Money\Money;
use Money\Currency;
use BrokeYourBike\MoneyCasts\CurrencyMissmatchException;

/**
 * @author Ivan Stasiuk <brokeyourbike@gmail.com>
 */
class MoneyCastTest extends TestCase
{
    /** @test */
    public function it_returns_amount_as_money_object(): void
    {
        $order = new AdvancedOrderFixture();
        $order->currency_code = 'GBP';
        $order->amount_in_cents = '100';

        $this->assertInstanceOf(Money::class, $order->amount);
    }

    /** @test */
    public function it_can_set_amount_from_money_object()
    {
        $order = new AdvancedOrderFixture();
        $order->currency_code = 'GBP';
        $this->assertNull($order->amount_in_cents);

        $order->amount = new Money(123, new Currency('GBP'));
        $this->assertSame('123', $order->amount_in_cents);
    }

    /**
     * @test
     * @dataProvider storedValuesProvider */
    public function it_should_throw_if_stored_amount_value_is($storedValue, $shouldThrow)
    {
        $order = new AdvancedOrderFixture();
        $order->currency_code = 'GBP';
        $order->amount_in_cents = $storedValue;

        try {
            $amount = $order->amount;
            $this->assertInstanceOf(Money::class, $amount);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(\InvalidArgumentException::class, $th);
        }

        if ($shouldThrow) {
            $this->assertFalse(isset($amount));
        }
    }

    public function storedValuesProvider(): array
    {
        return [
            ['123', false],
            [123, false],
            [1.23, true],
        ];
    }

    /** @test */
    public function it_will_throw_if_stored_currency_value_is_not_a_string()
    {
        $order = new AdvancedOrderFixture();
        $order->currency_code = 123;
        $order->amount_in_cents = 123;

        $this->expectExceptionMessage('The stored Money\Currency value should be not-empty-sting');
        $this->expectException(\InvalidArgumentException::class);

        $order->amount;
    }

    /** @test */
    public function it_will_throw_during_set_if_stored_currency_value_is_not_a_string()
    {
        $order = new AdvancedOrderFixture();
        $order->currency_code = 123;

        $this->expectExceptionMessage('The stored Money\Currency value should be not-empty-sting');
        $this->expectException(\InvalidArgumentException::class);

        $order->amount = new Money(456, new Currency('GBP'));
    }

    /** @test */
    public function it_will_throw_if_given_value_is_not_a_money_object()
    {
        $order = new AdvancedOrderFixture();

        $this->expectExceptionMessage('The given value is not an '. Money::class .' instance');
        $this->expectException(\InvalidArgumentException::class);

        $order->amount = 1234;
    }

    /** @test */
    public function it_will_throw_if_currency_of_the_given_value_does_not_match_stored_currency()
    {
        $order = new AdvancedOrderFixture();
        $order->currency_code = 'GBP';

        $this->expectExceptionMessage('Currencies do not match: GBP != USD');
        $this->expectException(CurrencyMissmatchException::class);

        $order->amount = new Money(456, new Currency('USD'));
    }
}
