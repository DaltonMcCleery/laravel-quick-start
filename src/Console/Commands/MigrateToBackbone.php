<?php

namespace DaltonMcCleery\LaravelQuickStart\Console\Commands;

use DaltonMcCleery\LaravelQuickStart\Models\BannerPromo;
use DaltonMcCleery\LaravelQuickStart\Models\NavigationMenu;
use DaltonMcCleery\LaravelQuickStart\Models\Page;
use DaltonMcCleery\LaravelQuickStart\Models\Redirect;
use DaltonMcCleery\LaravelQuickStart\Models\ReusableBlock;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class MigrateToBackbone extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'migrate:backbone';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Migrate application to Backbone';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	public function handle()
	{
		// Save all the data to JSON files
		Storage::put('pages.json', Page::all()->toJson());
		Storage::put('notifications.json', BannerPromo::all()->toJson());
		Storage::put('redirects.json', Redirect::all()->toJson());
		Storage::put('menus.json', NavigationMenu::all()->toJson());
		Storage::put('reusable_blocks.json', ReusableBlock::all()->toJson());

		// Delete tables
		Schema::disableForeignKeyConstraints();
		Schema::dropIfExists('pages');
		Schema::dropIfExists('banner_promos');
		Schema::dropIfExists('navigation_menu');
		Schema::dropIfExists('reusable_blocks');
		Schema::dropIfExists('model_revisions');
		Schema::dropIfExists('redirects');
		Schema::enableForeignKeyConstraints();

		// Delete migration/config files
		File::delete([
			config_path('quickstart.php'),
			database_path('migrations/2021_04_28_15322_create_pages_table.php'),
			database_path('migrations/2021_04_28_20223_create_banner_promos.php'),
			database_path('migrations/2021_04_28_20345_create_navigation_menu.php'),
			database_path('migrations/2021_05_06_10422_create_reusable_blocks.php'),
			database_path('migrations/2021_05_10_185811_create_model_revisions_table.php'),
			database_path('migrations/2021_06_11_191232_create_redirect_table.php'),
		]);

		return 1;
	}
}