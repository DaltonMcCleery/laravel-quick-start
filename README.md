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
        \DaltonMcCleery\LaravelQuickStart\Nova\MainNavMenu::class,
        \DaltonMcCleery\LaravelQuickStart\Nova\BannerPromos::class,
        \DaltonMcCleery\LaravelQuickStart\Nova\MobileNavMenu::class,
        \DaltonMcCleery\LaravelQuickStart\Nova\FooterNavMenu::class,
        \DaltonMcCleery\LaravelQuickStart\Nova\ReusableBlocks::class
    ]);
}
```

### Model Revisions

To include Revisional history of changes, add the following Trait to your Model:

```php
use DaltonMcCleery\LaravelQuickStart\Traits\HasModelRevisions;

class YourModel extends Model
{
	use HasModelRevisions;
```

If you're using Nova, you'll need to update your Model's `boot` method as follows:

```php
use DaltonMcCleery\LaravelQuickStart\Traits\HasModelRevisions;

class YourModel extends Model
{

    /**
	 * The "booted" method of the model.
	 *
	 * @return void
	 */
	protected static function booted()
	{
		static::updating(function ($model) {
			if ($model->create_new_revision) {
				self::create_static_revision($model);
			}
		});
	}
```

Lastly, add a checkbox field to that Model's Nova resource, like so:

```php
Boolean::make('Create New Revision', 'create_new_revision')
    ->trueValue(1)
    ->falseValue(0)
    ->help('Create a new revision upon saving that can be reverted to at any time.')
    ->rules('nullable')
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
