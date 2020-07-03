# Laravel Queue Batch Retry

[![Actions Status](https://github.com/kirschbaum-development/laravel-queue-batch-retry/workflows/CI/badge.svg)](https://github.com/kirschbaum-development/laravel-queue-batch-retry/actions)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/kirschbaum-development/laravel-queue-batch-retry.svg?style=flat-square)](https://packagist.org/packages/kirschbaum-development/laravel-queue-batch-retry)

Package to retry failed jobs in batches using custom filters.

## Installation

You can install the package via composer:

```console
composer require kirschbaum-development/laravel-queue-batch-retry
```

## Usage

You have a few different filters you can use to retry jobs in batches.

```console
php artisan queue:batch-retry --failed-after="2 days ago" --queue="default" --limit=10 --filter="CrawlWebsiteJob"
```

**--filter**

The `failed_jobs` table is not really a structured table, so "searching" is basically a `like` condition on the `payload` condition. Using this option, depending on how many records you have, could be very slow since it will have to do a full table scan to find results. Hopefully, you don't have a lot of failed jobs, though.

```console
php artisan queue:batch-retry --filter="PublishDocumentJob"
php artisan queue:batch-retry --filter="12234"
```

**--failed-after**

This option filters `failed_at` column. So let's say you had a bunch of jobs that failed today because of some API error in one of the services you use. You can retry all the jobs that failed since "today".

```console
php artisan queue:batch-retry --failed-after="today"
```

**--limit**

In case you want to run in just a specific number of jobs.

```console
php artisan queue:batch-retry --limit=10
```

**--dry-run**

We always get afraid of screwing things up, right? You can run dry run the command and see what's going to be executed first.

```console
php artisan queue:batch-retry --dry-run
```

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
