<?php

// Copyright (C) 2021 Ivan Stasiuk <brokeyourbike@gmail.com>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\MoneyCasts\Tests;

use PHPUnit\Framework\TestCase;
use Money\Currency;

/**
 * @author Ivan Stasiuk <brokeyourbike@gmail.com>
 */
class CurrencyCastTest extends TestCase
{
    /** @test */
    public function it_returns_currency_as_currency_object(): void
    {
        $order = new AdvancedOrderFixture();
        $order->currency_code = 'GBP';

        $this->assertInstanceOf(Currency::class, $order->currency);
    }

    /** @test */
    public function it_can_set_currency_code_from_currency_object()
    {
        $order = new AdvancedOrderFixture();
        $this->assertNull($order->currency_code);

        $order->currency = new Currency('GBP');
        $this->assertSame('GBP', $order->currency_code);
    }

    /** @test */
    public function it_will_throw_if_stored_value_is_not_string()
    {
        $order = new AdvancedOrderFixture();
        $order->currency_code = 123;

        $this->expectExceptionMessage('The stored value should be not-empty-sting');
        $this->expectException(\InvalidArgumentException::class);

        $order->currency;
    }

    /** @test */
    public function it_will_throw_if_stored_value_is_empty_string()
    {
        $order = new AdvancedOrderFixture();
        $order->currency_code = '';

        $this->expectExceptionMessage('The stored value should be not-empty-sting');
        $this->expectException(\InvalidArgumentException::class);

        $order->currency;
    }

    /** @test */
    public function it_will_not_throw_if_stored_value_is_not_a_valid_currency()
    {
        $order = new AdvancedOrderFixture();
        $order->currency_code = 'NOT-A-CURRENCY-CODE';

        $this->assertInstanceOf(Currency::class, $order->currency);
    }

    /** @test */
    public function it_will_throw_if_given_value_is_not_a_currency_object()
    {
        $order = new AdvancedOrderFixture();

        $this->expectExceptionMessage('The given value is not an '. Currency::class .' instance');
        $this->expectException(\InvalidArgumentException::class);

        $order->currency = 'GBP';
    }
}
