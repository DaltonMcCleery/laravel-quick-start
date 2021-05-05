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

### Laravel Nova

Update your `NovaServiceProvider` to include the following changes:

```php
/**
 * Register the application's Nova resources.
 *
 * @return void
*/
protected function resources()
{
    Nova::resourcesIn(app_path('Nova'));

    Nova::resources([
        \DaltonMcCleery\LaravelQuickStart\Nova\Page::class,
        \DaltonMcCleery\LaravelQuickStart\Nova\BannerPromos::class,
        \DaltonMcCleery\LaravelQuickStart\Nova\MainNavMenu::class,
        \DaltonMcCleery\LaravelQuickStart\Nova\MobileNavMenu::class,
        \DaltonMcCleery\LaravelQuickStart\Nova\FooterNavMenu::class
    ]);
}
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
