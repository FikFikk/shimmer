<?php

namespace Fikfikk\Shimmer;

use Illuminate\Support\ServiceProvider;
use Fikfikk\Shimmer\View\Components\ImageShimmer;

class ShimmerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'shimmer');

        // Publish config
        $this->publishes([
            __DIR__ . '/config/shimmer.php' => config_path('shimmer.php'),
        ], 'shimmer-config');

        // Publish views (optional, jika user mau customize)
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/shimmer'),
        ], 'shimmer-views');

        // Publish assets (CSS & JS)
        $this->publishes([
            __DIR__ . '/../dist' => public_path('vendor/shimmer'),
        ], 'shimmer-assets');

        // Register Blade component
        $this->loadViewComponentsAs('shimmer', [
            ImageShimmer::class,
        ]);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/shimmer.php', 'shimmer');
    }
}
