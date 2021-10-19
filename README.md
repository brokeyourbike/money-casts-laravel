# money-casts-laravel

[![Latest Stable Version](https://img.shields.io/github/v/release/brokeyourbike/money-casts-laravel)](https://github.com/brokeyourbike/money-casts-laravel/releases)
[![Total Downloads](https://poser.pugx.org/brokeyourbike/money-casts-laravel/downloads)](https://packagist.org/packages/brokeyourbike/money-casts-laravel)
[![License: MPL-2.0](https://img.shields.io/badge/license-MPL--2.0-purple.svg)](https://github.com/brokeyourbike/money-casts-laravel/blob/main/LICENSE)

[![ci](https://github.com/brokeyourbike/money-casts-laravel/actions/workflows/ci.yml/badge.svg)](https://github.com/brokeyourbike/money-casts-laravel/actions/workflows/ci.yml)
[![codecov](https://codecov.io/gh/brokeyourbike/money-casts-laravel/branch/main/graph/badge.svg?token=ImcgnxzGfc)](https://codecov.io/gh/brokeyourbike/money-casts-laravel)
[![Type Coverage](https://shepherd.dev/github/brokeyourbike/money-casts-laravel/coverage.svg)](https://shepherd.dev/github/brokeyourbike/money-casts-laravel)

Cast attributes to Money object

## Installation

```bash
composer require brokeyourbike/money-casts-laravel
```

## Usage

```php
use Illuminate\Database\Eloquent\Model;
use BrokeYourBike\MoneyCasts\CurrencyCast;
use BrokeYourBike\MoneyCasts\MoneyCast;

class Order extends Model
{
    protected $casts = [
        'currency' => CurrencyCast::class . ':currency_code',
        'amount' => MoneyCast::class . ':amount_in_cents',
    ];
}
```

## License
[Mozilla Public License v2.0](https://github.com/brokeyourbike/money-casts-laravel/blob/main/LICENSE)
