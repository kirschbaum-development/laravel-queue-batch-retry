<?php

namespace KirschbaumDevelopment\BatchRetry\Tests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use KirschbaumDevelopment\BatchRetry\FailedJob;

class BatchDeleteCommandTest extends TestCase
{
    /** @test */
    public function it_can_delete_all_jobs()
    {
        $failedJobs = factory(FailedJob::class, 5)->create();

        Artisan::call('queue:batch-delete');

        $this->assertCount(0, $failedJobs->fresh()->filter());
    }

    /** @test */
    public function it_can_batch_delete_filtering_by_queue()
    {
        $failedJobDefault = factory(FailedJob::class)->create();
        $failedJobPriority = factory(FailedJob::class)->create([
            'queue' => 'priority',
        ]);

        Artisan::call('queue:batch-delete', [
            '--queue' => 'priority',
        ]);

        $this->assertNull($failedJobPriority->fresh());
        $this->assertNotNull($failedJobDefault->fresh());
    }

    /** @test */
    public function it_can_batch_retry_with_limit_clause()
    {
        $failedJobsThatShouldRetry = factory(FailedJob::class, 2)->create();
        $failedJobsThatShouldNotRetry = factory(FailedJob::class, 2)->create();

        Artisan::call('queue:batch-delete', [
            '--limit' => 2,
        ]);

        $this->assertCount(0, $failedJobsThatShouldRetry->fresh()->filter());
        $this->assertCount(2, $failedJobsThatShouldNotRetry->fresh()->filter());
    }

    /** @test */
    public function it_can_batch_delete_using_search()
    {
        $someFailedJob = factory(FailedJob::class)->create([
            'payload' => ['displayName' => 'App\Jobs\SomeJob']
        ]);
        $someOtherFailedJob = factory(FailedJob::class)->create([
            'payload' => ['displayName' => 'App\Jobs\SomeOtherJob']
        ]);

        Artisan::call('queue:batch-delete', [
            '--filter' => 'SomeJob',
        ]);

        $this->assertNull($someFailedJob->fresh());
        $this->assertNotNull($someOtherFailedJob->fresh());
    }

    /** @test */
    public function it_can_batch_delete_limiting_by_date()
    {
        $newJobs = factory(FailedJob::class, 5)->create(['failed_at' => now()]);
        $oldJobs = factory(FailedJob::class, 5)->create(['failed_at' => now()->subDays(10)]);

        Artisan::call('queue:batch-delete', [
            '--failed-after' => '5 days ago',
        ]);

        $this->assertCount(0, $newJobs->fresh()->filter());
        $this->assertCount(5, $oldJobs->fresh()->filter());
    }

    /** @test */
    public function it_can_batch_delete_limiting_by_date_before()
    {
        $newJobs = factory(FailedJob::class, 5)->create(['failed_at' => now()]);
        $oldJobs = factory(FailedJob::class, 5)->create(['failed_at' => now()->subDays(10)]);

        Artisan::call('queue:batch-delete', [
            '--failed-before' => '5 days ago',
        ]);

        $this->assertCount(5, $newJobs->fresh()->filter());
        $this->assertCount(0, $oldJobs->fresh()->filter());
    }
}
