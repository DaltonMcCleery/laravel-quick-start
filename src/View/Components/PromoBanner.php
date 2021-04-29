<?php

namespace App\View\Components;

use DaltonMcCleery\LaravelQuickStart\Models\BannerPromo;
use Ahinkle\AutoResolvableComponents\AutoResolvableComponent;

class PromoBanner extends AutoResolvableComponent
{
    public $banner = null;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $now = new \DateTime('now');

        // Get all Active Banners with scheduling dates (if any)
        $banners = BannerPromo::where('active', 1)
            ->whereNotNull('start_on')
            ->whereNotNull('end_on')
            ->whereDate('start_on', '<=', $now)
            ->whereDate('end_on', '>', $now)
            ->get();

        if ($banners->isNotEmpty()) {
            // Get first Banner
            $activeBanner = $banners[0];
        } else {
            // See if there's an Active Banner
            $activeBanner = BannerPromo::where('active', 1)
                ->whereNull(['start_on', 'end_on'])
                ->first();
        }

        if ($activeBanner) {
            $this->banner = $activeBanner->content;
        }
    }
}
