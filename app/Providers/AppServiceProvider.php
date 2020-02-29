<?php

namespace App\Providers;

use App\Services\ThumbnailService\SpatieThumbnailService;
use App\Services\ThumbnailService\ThumbnailServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(ThumbnailServiceInterface::class, function(){
            return new SpatieThumbnailService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
