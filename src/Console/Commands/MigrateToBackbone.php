<?php

namespace DaltonMcCleery\LaravelQuickStart\Console\Commands;

use DaltonMcCleery\LaravelQuickStart\Models\BannerPromo;
use DaltonMcCleery\LaravelQuickStart\Models\NavigationMenu;
use DaltonMcCleery\LaravelQuickStart\Models\Page;
use DaltonMcCleery\LaravelQuickStart\Models\Redirect;
use DaltonMcCleery\LaravelQuickStart\Models\ReusableBlock;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
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
		$this->line('Backing up data...');
		Storage::put('pages.json', Page::all()->toJson());
		Storage::put('notifications.json', BannerPromo::all()->toJson());
		Storage::put('redirects.json', Redirect::all()->toJson());
		Storage::put('menus.json', NavigationMenu::all()->toJson());
		Storage::put('reusable_blocks.json', ReusableBlock::all()->toJson());

		// Delete tables
		$this->line('Deleting tables...');
		Schema::disableForeignKeyConstraints();
		Schema::dropIfExists('pages');
		Schema::dropIfExists('banner_promos');
		Schema::dropIfExists('navigation_menu');
		Schema::dropIfExists('reusable_blocks');
		Schema::dropIfExists('model_revisions');
		Schema::dropIfExists('redirects');
		Schema::enableForeignKeyConstraints();

		// Delete migration/config files
		$this->line('Deleting old migrations...');
		File::delete([
			config_path('quickstart.php'),
			database_path('migrations/2021_04_28_15322_create_pages_table.php'),
			database_path('migrations/2021_04_28_20223_create_banner_promos.php'),
			database_path('migrations/2021_04_28_20345_create_navigation_menu.php'),
			database_path('migrations/2021_05_06_10422_create_reusable_blocks.php'),
			database_path('migrations/2021_05_10_185811_create_model_revisions_table.php'),
			database_path('migrations/2021_06_11_191232_create_redirect_table.php'),
		]);

		DB::table('migrations')
			->where('migration', '2021_04_28_15322_create_pages_table')
			->orWhere('migration', '2021_04_28_20223_create_banner_promos')
			->orWhere('migration', '2021_04_28_20345_create_navigation_menu')
			->orWhere('migration', '2021_05_06_10422_create_reusable_blocks')
			->orWhere('migration', '2021_05_10_185811_create_model_revisions_table')
			->orWhere('migration', '2021_06_11_191232_create_redirect_table')
			->delete();

		$this->line('Migrating new tables...');
		Artisan::call('migrate');

		Model::unguard();
		$this->importPages();
		$this->importNotifications();
		$this->importReusableBlocks();
		$this->importRedirects();
		$this->importMenus();

		$this->info('Done!');

		return 1;
	}

	private function importPages(): void
	{
		$this->line('Importing Pages...');

		$pages = json_decode(Storage::get('pages.json'));

		foreach ($pages as $page) {
			$page = new Page((array) $page);

			\Grayloon\LaravelBackbone\Models\Page::withoutEvents(function () use ($page) {
				\Grayloon\LaravelBackbone\Models\Page::create([
					'id' => $page->id,
					'name' => $page->name,
					'slug' => $page->slug,
					'content' => $page->content,
					'is_indexable' => true,
					'is_active' => $page->active,
					'author_id' => null,
					'editor_id' => null,
					'meta_title' => $page->meta_title,
					'meta_description' => $page->meta_description,
					'og_title' => $page->og_title,
					'og_description' => $page->og_description,
					'og_image' => $page->social_image,
					'pageable_id' => $page->extendable_page_id,
					'pageable_type' => $page->extendable_page_type,
					'deleted_at' => $page->deleted_at,
				]);
			});
		}
	}

	private function importNotifications(): void
	{
		$this->line('Importing Notifications...');

		$banners = json_decode(Storage::get('notifications.json'));

		foreach ($banners as $banner) {
			$banner = new BannerPromo((array) $banner);

			\Grayloon\LaravelBackbone\Models\NotificationBar::create([
				'name' => $banner->name,
				'content' => $banner->content,
				'is_active' => $banner->active,
				'start_on' => $banner->start_on,
				'end_on' => $banner->end_on,
				'deleted_at' => $banner->deleted_at,
			]);
		}
	}

	private function importReusableBlocks(): void
	{
		$this->line('Importing Reusable Blocks...');

		$blocks = json_decode(Storage::get('reusable_blocks.json'));

		foreach ($blocks as $block) {
			$block = new ReusableBlock((array) $block);

			\Grayloon\LaravelBackbone\Models\ReusableBlock::create([
				'id' => $block->id,
				'name' => $block->name,
				'content' => $block->content,
				'is_active' => $block->active,
			]);
		}
	}

	private function importRedirects(): void
	{
		$this->line('Importing Redirects...');

		$redirects = json_decode(Storage::get('redirects.json'));

		foreach ($redirects as $redirect) {
			$redirect = new Redirect((array) $redirect);

			\Grayloon\LaravelBackbone\Models\Redirect::create([
				'from_url' => $redirect->from_url,
				'to_url' => $redirect->to_url,
				'status_code' => $redirect->status_code,
			]);
		}
	}

	private function importMenus(): void
	{
		$this->line('Importing Menus...');

		$menus = json_decode(Storage::get('menus.json'));

		foreach ($menus as $menu) {
			$menu = new NavigationMenu((array) $menu);

			$newMenu = \Grayloon\LaravelBackbone\Models\Menu::updateOrCreate(
				['title' => $menu->type],
				['is_active' => true]
			);

			\Grayloon\LaravelBackbone\Models\MenuItem::create([
				'id' => $menu->id,
				'menu_id' => $newMenu->id,
				'item_id' => $menu->page_id,
				'item_type' => $menu->page_id ? \Grayloon\LaravelBackbone\Models\Page::class : null,
				'parent_id' => $menu->parent_id,
				'parent_type' => $menu->parent_id ? \Grayloon\LaravelBackbone\Models\MenuItem::class : null,
				'position' => $menu->menu_order,
				'custom_link' => $menu->link,
				'alternative_label' => $menu->name,
				'deleted_at' => $menu->deleted_at,
			]);
		}
	}
}
