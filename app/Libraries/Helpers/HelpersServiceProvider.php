<?php

namespace App\Libraries\Helpers;

use Illuminate\Support\ServiceProvider;

class HelpersServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->app->bind('App\Libraries\Helpers\Helpers', function ($app) {
            return new Helpers();
        });
    }
}
