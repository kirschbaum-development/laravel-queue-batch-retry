<?php

namespace KirschbaumDevelopment\BatchRetry;

use Illuminate\Database\Eloquent\Model;

class FailedJob extends Model
{
    protected $guarded = [];
    protected $table = 'failed_jobs';
    public $timestamps = false;

    protected $casts = ['failed_at' => 'datetime'];

    public function __construct(array $attributes = [])
    {
        if (config('queue.failed.table')) {
            $this->table = config('queue.failed.table');
        }

        parent::__construct($attributes);
    }

    public function setPayloadAttribute($payload)
    {
        $this->attributes['payload'] = serialize($payload);
    }
}
