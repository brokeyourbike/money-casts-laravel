<?php

// Copyright (C) 2021 Ivan Stasiuk <brokeyourbike@gmail.com>.
//
// This Source Code Form is subject to the terms of the Mozilla Public
// License, v. 2.0. If a copy of the MPL was not distributed with this file,
// You can obtain one at https://mozilla.org/MPL/2.0/.

namespace BrokeYourBike\MoneyCasts\Tests;

use Illuminate\Database\Eloquent\Model;
use BrokeYourBike\MoneyCasts\MoneyCast;
use BrokeYourBike\MoneyCasts\CurrencyCast;

/**
 * @author Ivan Stasiuk <brokeyourbike@gmail.com>
 */
class AdvancedOrderFixture extends Model
{
    /**
     * The attributes that should be cast to native types.
     *
     * @var array<mixed>
     */
    protected $casts = [
        'currency_code' => 'string',
        'amount_in_cents' => 'string',
        'currency' => CurrencyCast::class . ':currency_code',
        'amount' => MoneyCast::class . ':amount_in_cents,currency_code',
    ];
}
