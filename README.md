# Laravel Queue Batch Retry

[![Latest Version on Packagist](https://img.shields.io/packagist/v/kirschbaum-development/laravel-queue-batch-retry.svg?style=flat-square)](https://packagist.org/packages/kirschbaum-development/laravel-queue-batch-retry)
[![Build Status](https://img.shields.io/travis/kirschbaum-development/laravel-queue-batch-retry/master.svg?style=flat-square)](https://travis-ci.org/kirschbaum-development/laravel-queue-batch-retry)
[![Quality Score](https://img.shields.io/scrutinizer/g/kirschbaum-development/laravel-queue-batch-retry.svg?style=flat-square)](https://scrutinizer-ci.com/g/kirschbaum-development/laravel-queue-batch-retry)
[![Total Downloads](https://img.shields.io/packagist/dt/kirschbaum-development/laravel-queue-batch-retry.svg?style=flat-square)](https://packagist.org/packages/kirschbaum-development/laravel-queue-batch-retry)

Package to retry failed jobs in batches using custom filters.

## Installation

You can install the package via composer:

```bash
composer require kirschbaum-development/laravel-queue-batch-retry
```

## Usage

You have a few different filters you can use to retry jobs in batches.

```bash
php artisan queue:batch-retry --failed-after="2 days ago" --queue="default" --limit=10 --filter="CrawlWebsiteJob"
```

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email luis.nh@gmail.com instead of using the issue tracker.

## Credits

- [Luis Dalmolin](https://github.com/kirschbaum-development)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
