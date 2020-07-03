<?php

namespace KirschbaumDevelopment\LaravelQueueBatchRetry\Tests;

use Orchestra\Testbench\TestCase;
use KirschbaumDevelopment\LaravelQueueBatchRetry\LaravelQueueBatchRetryServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [LaravelQueueBatchRetryServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
