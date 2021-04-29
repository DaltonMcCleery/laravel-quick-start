<?php

namespace DaltonMcCleery\LaravelQuickStart\View\Composers;

use Illuminate\View\View;
use DaltonMcCleery\LaravelQuickStart\Traits\CacheTrait;
use DaltonMcCleery\LaravelQuickStart\Models\NavigationMenu;

class NavigationMenuComposer
{
    use CacheTrait;

    /**
     * Create a new profile composer.
     *
     * @return void
     */
    public function __construct() {}

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function create(View $view)
    {
        // Get all DESKTOP Menu items
        $desktop_menu = $this->getCache('desktop_menu', function() {
            // Empty cache, get menu items and re-add them to the cache
            $dbItems = NavigationMenu::with('Children')
                ->where('type', 'DESKTOP')
                ->whereNull('parent_id')
                ->orderBy('menu_order')
                ->get();

            // Set new cached page info
            $this->setCache('desktop_menu', $dbItems);

            return $dbItems;
        });

        // MOBILE
        $mobile_menu = $this->getCache('mobile_menu', function() {
            // Empty cache, get menu items and re-add them to the cache
            $dbItems = NavigationMenu::with('Children')
                ->where('type', 'MOBILE')
                ->whereNull('parent_id')
                ->orderBy('menu_order')
                ->get();

            // Set new cached page info
            $this->setCache('mobile_menu', $dbItems);

            return $dbItems;
        });

        // FOOTER
        $footer_menu = $this->getCache('footer_menu', function() {
            // Empty cache, get menu items and re-add them to the cache
            $dbItems = NavigationMenu::where('type', 'FOOTER')
                ->whereNull('parent_id')
                ->orderBy('menu_order')
                ->get();

            // Set new cached page info
            $this->setCache('footer_menu', $dbItems);

            return $dbItems;
        });

        $view->with([
            'desktop_navigation_menu' => $desktop_menu,
            'mobile_navigation_menu' => $mobile_menu,
            'footer_navigation_menu' => $footer_menu
        ]);
    }
}
