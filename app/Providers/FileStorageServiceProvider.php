<?php

namespace App\Providers;

use App\Contracts\FileStorageServiceContract;
use App\Services\FileServices\DefaultFileService;
use Illuminate\Support\ServiceProvider;

class FileStorageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(FileStorageServiceContract::class, function () {
            return new DefaultFileService();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
