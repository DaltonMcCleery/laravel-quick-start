# Laravel Quick Start

## Requirements

This package is dependent on some 3rd party Laravel Nova packages, outlined below, so you must have Nova installed and configured prior to installing this package.

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
                $model = self::create_static_revision($model);
            }
        });
    }
```

Next, add a checkbox field to that Model's Nova resource, like so:

```php
Boolean::make('Create New Revision', 'create_new_revision')
    ->trueValue(1)
    ->falseValue(0)
    ->hideFromDetail()->hideFromIndex()->hideWhenCreating()
    ->help('Create a new revision upon saving that can be reverted to at any time.')
    ->rules('nullable')
```

Lastly, you can add a Nova Action to your Model resource for reverting to a specific revision:

```php
use DaltonMcCleery\LaravelQuickStart\Nova\Actions\RevertRevision;

public function actions(Request $request)
{
    return [
        new RevertRevision($request->resourceId, $this)
    ];
}
```

Now you can create new revisions either statically (via static model closures) or non-statically 

```php
self::create_static_revision($model);

$this->create_revision($model);
```

You can also rollback to the latest revision, or specify an ID of a revision:

```php
$model->revert_last_revision();

$model->revert_to_revision(1);
```

## Built With

- [Auto Resolvable Laravel Blade Components](https://github.com/ahinkle/auto-resolvable-blade-components) _(Blade Component Auto Resolver)_
- [Nova Charcounted Fields](https://github.com/elevate-digital/nova-charcounted-fields) _(Text Fields)_
- [Nova Filemanager](https://github.com/InfinetyEs/Nova-Filemanager) _(File/Asset Manager)_
- [Nova Tiptap](https://github.com/manogi/nova-tiptap) _(Editor Field)_
- [Nova Flexible Content](https://github.com/whitecube/nova-flexible-content) _(Content Repeater Fields)_


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
