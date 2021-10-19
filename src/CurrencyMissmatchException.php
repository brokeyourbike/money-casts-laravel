<?php

// Copyright (C) 2021 Ivan Stasiuk <brokeyourbike@gmail.com>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\MoneyCasts;

use Money\Currency;

/**
 * @author Ivan Stasiuk <brokeyourbike@gmail.com>
 */
final class CurrencyMissmatchException extends \Exception
{
    /**
     * Creates an exception from Currency objects.
     *
     * @param Currency $localCurrency
     * @param Currency $newCurrency
     *
     * @return CurrencyMissmatchException
     */
    public static function createFromCurrencies(Currency $localCurrency, Currency $newCurrency): self
    {
        $message = sprintf(
            'Currencies do not match: %s != %s',
            $localCurrency->getCode(),
            $newCurrency->getCode()
        );

        return new self($message);
    }
}
