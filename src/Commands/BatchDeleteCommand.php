<?php

namespace KirschbaumDevelopment\BatchRetry\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use KirschbaumDevelopment\BatchRetry\FailedJob;

class BatchDeleteCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'queue:failed:batch-delete
        {--failed-before= : Only batch retry jobs failed before some specific date}
        {--failed-after= : Only batch retry jobs failed after some specific date}
        {--limit= : Limit the amount of jobs to retry}
        {--queue= : Only retry on a specific queue}
        {--filter= : Filter by a specific string. This will be a search in the payload of the job}
        {--filter-by-exception= : Filter by a specific string on the exception.}
        {--dry-run : Do a dry run of the batch retry to have an idea of the size of the batch}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete queue failed jobs in batch using filters.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $failedJobsQuery = FailedJob::query()
            ->when($this->option('queue'), function ($query) {
                $query->where('queue', $this->option('queue'));
            })
            ->when($this->option('failed-before'), function ($query) {
                $query->where(
                    'failed_at',
                    '<=',
                    Carbon::parse($this->option('failed-before'))->format('Y-m-d H:i:s')
                );
            })
            ->when($this->option('failed-after'), function ($query) {
                $query->where(
                    'failed_at',
                    '>=',
                    Carbon::parse($this->option('failed-after'))->format('Y-m-d H:i:s')
                );
            })
            ->when($this->option('filter'), function ($query) {
                $query->where('payload', 'like', '%'.$this->option('filter').'%');
            })
            ->when($this->option('filter-by-exception'), function ($query) {
                $query->where('exception', 'like', '%'.$this->option('filter-by-exception').'%');
            })
            ->when($this->option('limit'), function ($query) {
                $query->take($this->option('limit'));
            });

        if ($this->option('dry-run')) {
            $this->comment($failedJobsQuery->count() . ' failed jobs will be deleted');
        } else {
            $total = $failedJobsQuery->delete();
            $this->comment($total . ' jobs were deleted');
        }
    }
}
