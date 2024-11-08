<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
{
    $this->app->singleton(ChatbotService::class, function ($app) {
        return new ChatbotService();
    });
}


    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
