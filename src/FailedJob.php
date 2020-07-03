<?php

namespace KirschbaumDevelopment\BatchRetry;

use Illuminate\Database\Eloquent\Model;

class FailedJob extends Model
{
    protected $guarded = [];
    protected $table = 'failed_jobs';
    public $timestamps = false;

    protected $casts = ['failed_at' => 'datetime'];

    public function setPayloadAttribute($payload)
    {
        $this->attributes['payload'] = serialize($payload);
    }
}
