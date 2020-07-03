<?php

use KirschbaumDevelopment\BatchRetry\FailedJob;

$factory->define(FailedJob::class, function (Faker\Generator $faker) {
    return [
        'connection' => 'database',
        'queue' => 'default',
        'payload' => [
            'displayName' => 'App\Jobs\SomeJob',
        ],
        'exception' => 'something',
    ];
});
