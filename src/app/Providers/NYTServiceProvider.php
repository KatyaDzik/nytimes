<?php

namespace App\Providers;

use App\Services\NYTIntegration;
use Illuminate\Support\ServiceProvider;

class NYTServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(NYTIntegration::class, function ($app) {
            return new NYTIntegration(config('services.nyt.api_key'), config('services.nyt.base_url'));
        });
    }
}
