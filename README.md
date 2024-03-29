# money-casts-laravel

[![Latest Stable Version](https://img.shields.io/github/v/release/brokeyourbike/money-casts-laravel)](https://github.com/brokeyourbike/money-casts-laravel/releases)
[![Total Downloads](https://poser.pugx.org/brokeyourbike/money-casts-laravel/downloads)](https://packagist.org/packages/brokeyourbike/money-casts-laravel)
[![Maintainability](https://api.codeclimate.com/v1/badges/f99d65901d74370f68e0/maintainability)](https://codeclimate.com/github/brokeyourbike/money-casts-laravel/maintainability)
[![Test Coverage](https://api.codeclimate.com/v1/badges/f99d65901d74370f68e0/test_coverage)](https://codeclimate.com/github/brokeyourbike/money-casts-laravel/test_coverage)

Cast attributes to [Money](https://github.com/moneyphp/money) objects

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
        'amount' => MoneyCast::class . ':amount_in_cents,currency_code',
    ];
}
```

## Authors
- [Ivan Stasiuk](https://github.com/brokeyourbike) | [Twitter](https://twitter.com/brokeyourbike) | [LinkedIn](https://www.linkedin.com/in/brokeyourbike) | [stasi.uk](https://stasi.uk)

## License
[Mozilla Public License v2.0](https://github.com/brokeyourbike/money-casts-laravel/blob/main/LICENSE)
