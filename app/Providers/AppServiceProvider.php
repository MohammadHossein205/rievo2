<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
//        $this->app->bind('path.public', function () {
//            return base_path('public_html');
//        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
//        JsonResource::withoutWrapping();
    }
}
