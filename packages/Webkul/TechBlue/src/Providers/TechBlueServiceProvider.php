<?php

namespace Webkul\TechBlue\Providers;

use Illuminate\Support\ServiceProvider;

class TechBlueServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'techblue');
    }
}
