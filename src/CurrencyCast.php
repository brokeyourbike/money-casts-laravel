<?php

// Copyright (C) 2021 Ivan Stasiuk <brokeyourbike@gmail.com>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\MoneyCasts;

use Money\Currency;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * @author Ivan Stasiuk <brokeyourbike@gmail.com>
 */
class CurrencyCast implements CastsAttributes
{
    /**
     * Name of the source attribute.
     *
     * @var string
     */
    protected string $sourceAttributeName;

    /**
     * Create a new cast class instance.
     *
     * @param  string  $sourceAttributeName
     * @return void
     */
    public function __construct(string $sourceAttributeName)
    {
        $this->sourceAttributeName = $sourceAttributeName;
    }

    /**
     * Transform the attribute from the underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return \Money\Currency
     */
    public function get($model, string $key, $value, array $attributes)
    {
        $currencyCode = isset($attributes[$this->sourceAttributeName])
            ? $attributes[$this->sourceAttributeName]
            : null;

        if (!is_string($currencyCode) || (is_string($currencyCode) && !$currencyCode)) {
            throw new \InvalidArgumentException('The stored value should be not-empty-sting');
        }

        return new Currency($currencyCode);
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
        if (!$value instanceof Currency) {
            throw new \InvalidArgumentException('The given value is not an '. Currency::class .' instance');
        }

        return [$this->sourceAttributeName => $value->getCode()];
    }
}
