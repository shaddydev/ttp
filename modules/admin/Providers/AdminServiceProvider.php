<?php

namespace Admin\Providers;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/routes.php');
        $this->publishes([
            __DIR__ . '/../config/admin.php' => config_path('admin.php'),
        ], 'config');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'admin');
        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/admin'),
        ], 'lang');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'admin');
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/admin'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/admin'),
        ], 'public');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
