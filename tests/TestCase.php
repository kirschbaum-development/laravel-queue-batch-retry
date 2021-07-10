<?php

namespace KirschbaumDevelopment\BatchRetry\Tests;

use KirschbaumDevelopment\BatchRetry\BatchRetryServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $this->withFactories(__DIR__.'/database/factories');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }

    protected function defineEnvironment($app)
    {
        $app['config']->set('queue.default', 'database');
        $app['config']->set('queue.failed.driver', 'database');
    }

    protected function getPackageProviders($app)
    {
        return [BatchRetryServiceProvider::class];
    }
}
