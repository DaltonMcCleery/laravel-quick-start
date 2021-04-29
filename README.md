# Laravel Quick Start

## Installation

Install this package via Composer:

```composer
composer require daltonmccleery/laravel-quick-start
```

Publish all package assets into your application:
```bash
php artisan vendor:publish --provider="DaltonMcCleery\LaravelQuickStart\LaravelQuickStartServiceProvider" --force
```

Then, run the new migrations:
```bash
php artisan migrate
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
