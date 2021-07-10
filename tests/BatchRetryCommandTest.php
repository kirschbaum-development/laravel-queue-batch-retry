<?php

namespace KirschbaumDevelopment\BatchRetry\Tests;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use KirschbaumDevelopment\BatchRetry\FailedJob;

class BatchRetryCommandTest extends TestCase
{
    /** @test */
    public function it_can_retry_all_jobs()
    {
        $failedJobs = factory(FailedJob::class, 2)->create();

        Artisan::call('queue:failed:batch-retry');

        $failedJobs->each(function ($failedJob) {
            $this->assertEquals(2, DB::table('jobs')->count());
            $this->assertNull($failedJob->fresh());
        });
    }

    /** @test */
    public function making_sure_the_chunks_work()
    {
        $failedJobs = factory(FailedJob::class, 75)->create();
        $this->assertEquals(75, FailedJob::count());

        Artisan::call('queue:failed:batch-retry');

        $this->assertEquals(75, DB::table('jobs')->count());
        $this->assertEquals(0, FailedJob::count());
    }

    /** @test */
    public function it_can_batch_retry_filtering_by_queue()
    {
        $failedJobDefault = factory(FailedJob::class)->create();
        $failedJobPriority = factory(FailedJob::class)->create([
            'queue' => 'priority',
        ]);

        Artisan::call('queue:failed:batch-retry', [
            '--queue' => 'priority',
        ]);

        $this->assertEquals(1, DB::table('jobs')->count());
        $this->assertNull($failedJobPriority->fresh());
        $this->assertNotNull($failedJobDefault->fresh());
    }

    /** @test */
    public function it_can_batch_retry_with_limit_clause()
    {
        $failedJobsThatShouldRetry = factory(FailedJob::class, 2)->create();
        $failedJobsThatShouldNotRetry = factory(FailedJob::class, 2)->create();

        Artisan::call('queue:failed:batch-retry', [
            '--limit' => 2,
        ]);

        $this->assertEquals(2, DB::table('jobs')->count());

        $failedJobsThatShouldRetry->each(function ($failedJob) {
            $this->assertNull($failedJob->fresh());
        });

        $failedJobsThatShouldNotRetry->each(function ($failedJob) {
            $this->assertNotNull($failedJob->fresh());
        });
    }

    /** @test */
    public function it_can_batch_retry_using_search()
    {
        $someFailedJob = factory(FailedJob::class)->create([
            'payload' => ['displayName' => 'App\Jobs\SomeJob']
        ]);
        $someOtherFailedJob = factory(FailedJob::class)->create([
            'payload' => ['displayName' => 'App\Jobs\SomeOtherJob']
        ]);

        Artisan::call('queue:failed:batch-retry', [
            '--filter' => 'SomeJob',
        ]);

        $this->assertEquals(1, DB::table('jobs')->count());
        $this->assertNull($someFailedJob->fresh());
        $this->assertNotNull($someOtherFailedJob->fresh());
    }

    /** @test */
    public function it_can_batch_retry_limiting_by_date()
    {
        $newJobs = factory(FailedJob::class, 5)->create(['failed_at' => now()]);
        $oldJobs = factory(FailedJob::class, 5)->create(['failed_at' => now()->subDays(10)]);

        Artisan::call('queue:failed:batch-retry', [
            '--failed-after' => '5 days ago',
        ]);

        $this->assertEquals(5, DB::table('jobs')->count());
        $this->assertCount(0, $newJobs->fresh()->filter());
        $this->assertCount(5, $oldJobs->fresh()->filter());
    }

    /** @test */
    public function it_can_batch_retry_limiting_by_date_before()
    {
        $newJobs = factory(FailedJob::class, 5)->create(['failed_at' => now()]);
        $oldJobs = factory(FailedJob::class, 5)->create(['failed_at' => now()->subDays(10)]);

        Artisan::call('queue:failed:batch-retry', [
            '--failed-before' => '5 days ago',
        ]);

        $this->assertEquals(5, DB::table('jobs')->count());
        $this->assertCount(5, $newJobs->fresh()->filter());
        $this->assertCount(0, $oldJobs->fresh()->filter());
    }

    /** @test */
    public function it_can_retry_jobs_filtering_by_exception()
    {
        $modelNotFoundExceptionJobs = factory(FailedJob::class, 5)->create([
            'exception' => 'ModelNotFoundException',
        ]);

        $otherExceptionJobs = factory(FailedJob::class, 5)->create([
            'exception' => 'Exception',
        ]);

        Artisan::call('queue:failed:batch-retry', [
            '--filter-by-exception' => 'ModelNotFoundException'
        ]);

        $this->assertCount(0, $modelNotFoundExceptionJobs->fresh()->filter());
        $this->assertCount(5, $otherExceptionJobs->fresh()->filter());
        $this->assertEquals(5, DB::table('jobs')->count());
    }
}
