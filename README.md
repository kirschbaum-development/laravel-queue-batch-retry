# Laravel Queue Batch Retry

![Laravel Supported Versions](https://img.shields.io/badge/laravel-6.x/7.x-green.svg)
[![Actions Status](https://github.com/kirschbaum-development/laravel-queue-batch-retry/workflows/tests/badge.svg)](https://github.com/kirschbaum-development/laravel-queue-batch-retry/actions)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/kirschbaum-development/laravel-queue-batch-retry.svg?style=flat-square)](https://packagist.org/packages/kirschbaum-development/laravel-queue-batch-retry)

Laravel only allows you to retry one job per time or all of them when using the `queue:retry` command. This package gives you a few more options so you retry failed jobs in batches filtering to only the jobs you want.

## Installation

You can install the package via composer:

```console
composer require kirschbaum-development/laravel-queue-batch-retry
```

## Usage

There's two different commands this package provides.

### queue:failed:batch-retry

```console
php artisan queue:failed:batch-retry --failed-after="2 days ago" --queue="default" --limit=10 --filter="CrawlWebsiteJob" --filter-by-exception="ModelNotFoundException"
```

**--filter**

The `failed_jobs` table is not really a structured table, so "searching" is basically a `like` condition on the `payload` condition. Using this option, depending on how many records you have, could be very slow since it will have to do a full table scan to find results. Hopefully, you don't have a lot of failed jobs, though.

```console
php artisan queue:failed:batch-retry --filter="PublishDocumentJob"
php artisan queue:failed:batch-retry --filter="12234"
```

**--filter-by-exception**

Same as the `--filter` option, but for the `exception` column in the `failed_jobs` table. Using this option, depending on how many records you have, could be very slow since it will have to do a full table scan to find results.

```console
php artisan queue:failed:batch-retry --filter-by-exception="ModelNotFoundException"
php artisan queue:failed:batch-retry --filter-by-exception="Error when creating directory"
```

**--failed-after**

This option filters `failed_at` column. So let's say you had a bunch of jobs that failed today because of some API error in one of the services you use. You can retry all the jobs that failed since "today".

```console
php artisan queue:failed:batch-retry --failed-after="today"
```

**--failed-before**

Same as the failed-after, but looking at previous dates.

```console
php artisan queue:failed:batch-retry --failed-before="yesterday"
```

**--limit**

In case you want to run in just a specific number of jobs.

```console
php artisan queue:failed:batch-retry --limit=10
```

**--dry-run**

We always get afraid of screwing things up, right? You can run dry run the command and see what's going to be executed first.

```console
php artisan queue:failed:batch-retry --dry-run
```
### queue:failed:batch-delete

In case you simply want to clean up your failed jobs table, there's also a `queue:failed:batch-delete` command which works exactly the same as the `queue:failed:batch-retry` command. You can use the same filters and options provided by the retry command.

***

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email luis@kirschbaumdevelopment.com or nathan@kirschbaumdevelopment.com instead of using the issue tracker.

## Credits

- [Luis Dalmolin](https://github.com/luisdalmolin)

## Sponsorship

Development of this package is sponsored by Kirschbaum Development Group, a developer driven company focused on problem solving, team building, and community. Learn more [about us](https://kirschbaumdevelopment.com) or [join us](https://kirschbaumdevelopment.com/careers)!

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
