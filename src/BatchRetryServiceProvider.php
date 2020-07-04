<?php

namespace KirschbaumDevelopment\BatchRetry;

use Illuminate\Support\ServiceProvider;
use KirschbaumDevelopment\BatchRetry\Commands\BatchRetryCommand;
use KirschbaumDevelopment\BatchRetry\Commands\BatchDeleteCommand;

class BatchRetryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/config.php' => config_path('laravel-queue-batch-retry.php'),
            ], 'config');

            $this->commands([
                BatchRetryCommand::class,
                BatchDeleteCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-queue-batch-retry');
    }
}
