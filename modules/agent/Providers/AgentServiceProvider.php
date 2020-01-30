<?php

namespace Agent\Providers;

use Illuminate\Support\ServiceProvider;

class AgentServiceProvider extends ServiceProvider
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
            __DIR__ . '/../config/agent.php' => config_path('agent.php'),
        ], 'config');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'agent');
        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/agent'),
        ], 'lang');

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'agent');
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/agent'),
        ], 'views');

        $this->publishes([
            __DIR__ . '/../public' => public_path('vendor/agent'),
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
