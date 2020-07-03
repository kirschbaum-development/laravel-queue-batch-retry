<?php

namespace KirschbaumDevelopment\LaravelQueueBatchRetry;

use Illuminate\Support\Facades\Facade;

/**
 * @see \KirschbaumDevelopment\LaravelQueueBatchRetry\Skeleton\SkeletonClass
 */
class LaravelQueueBatchRetryFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-queue-batch-retry';
    }
}
