<?php

// Copyright (C) 2021 Ivan Stasiuk <brokeyourbike@gmail.com>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\MoneyCasts;

use Money\Money;
use Money\Currency;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * @author Ivan Stasiuk <brokeyourbike@gmail.com>
 */
class MoneyCast implements CastsAttributes
{
    /**
     * Name of the Money source attribute.
     *
     * @var string
     */
    protected string $sourceMoneyAttributeName;

    /**
     * Name of the Currency source attribute.
     *
     * @var string
     */
    protected string $sourceCurrencyAttributeName;

    /**
     * Create a new cast class instance.
     *
     * @param  string  $sourceMoneyAttributeName
     * @param  string  $sourceCurrencyAttributeName
     * @return void
     */
    public function __construct(string $sourceMoneyAttributeName, string $sourceCurrencyAttributeName)
    {
        $this->sourceMoneyAttributeName = $sourceMoneyAttributeName;
        $this->sourceCurrencyAttributeName = $sourceCurrencyAttributeName;
    }

    /**
     * Transform the attribute from the underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return Money
     *
     * @throws \InvalidArgumentException
     */
    public function get($model, string $key, $value, array $attributes)
    {
        $amountInCents = isset($attributes[$this->sourceMoneyAttributeName])
            ? $attributes[$this->sourceMoneyAttributeName]
            : null;

        if (filter_var($amountInCents, FILTER_VALIDATE_INT) === false) {
            throw new \InvalidArgumentException('The stored '. Money::class .' value should be integer(ish)');
        }

        $currencyCode = isset($attributes[$this->sourceCurrencyAttributeName])
            ? $attributes[$this->sourceCurrencyAttributeName]
            : null;

        if (!is_string($currencyCode) || (is_string($currencyCode) && !$currencyCode)) {
            throw new \InvalidArgumentException('The stored '. Currency::class .' value should be not-empty-sting');
        }

        return new Money($amountInCents, new Currency($currencyCode));
    }

    /**
     * Transform the attribute to its underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return array<string,string>
     */
    public function set($model, string $key, $value, array $attributes)
    {
        if (!$value instanceof Money) {
            throw new \InvalidArgumentException('The given value is not an '. Money::class .' instance');
        }

        $currencyCode = isset($attributes[$this->sourceCurrencyAttributeName])
            ? $attributes[$this->sourceCurrencyAttributeName]
            : null;

        if (!is_string($currencyCode) || (is_string($currencyCode) && !$currencyCode)) {
            throw new \InvalidArgumentException('The stored '. Currency::class .' value should be not-empty-sting');
        }

        $currency = new Currency($currencyCode);

        if (!$currency->equals($value->getCurrency())) {
            throw CurrencyMissmatchException::createFromCurrencies($currency, $value->getCurrency());
        }

        return [$this->sourceMoneyAttributeName => $value->getAmount()];
    }
}
