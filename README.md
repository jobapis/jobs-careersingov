# Careers in Government RSS Feed Client

[![Latest Version](https://img.shields.io/github/release/jobapis/jobs-careersingov.svg?style=flat-square)](https://github.com/jobapis/jobs-careersingov/releases)
[![Software License](https://img.shields.io/badge/license-APACHE%202.0-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/jobapis/jobs-careersingov/master.svg?style=flat-square&1)](https://travis-ci.org/jobapis/jobs-careersingov)
[![Coverage Status](https://img.shields.io/scrutinizer/coverage/g/jobapis/jobs-careersingov.svg?style=flat-square)](https://scrutinizer-ci.com/g/jobapis/jobs-careersingov/code-structure)
[![Quality Score](https://img.shields.io/scrutinizer/g/jobapis/jobs-careersingov.svg?style=flat-square)](https://scrutinizer-ci.com/g/jobapis/jobs-careersingov)
[![Total Downloads](https://img.shields.io/packagist/dt/jobapis/jobs-careersingov.svg?style=flat-square)](https://packagist.org/packages/jobapis/jobs-careersingov)

This package provides [CareersInGovernment.com](https://careersingovernment.com/) RSS feed support for [Jobs Common](https://github.com/jobapis/jobs-common).

## Installation

To install, use composer:

```
composer require jobapis/jobs-careersingov
```

## Usage
Careers in Government provides no search parameters, just a feed of all their latest jobs via RSS.

In order to grab jobs, first create a query object:
 
```php
// Instantiate the query object
$query = new JobApis\Jobs\Client\Queries\CareersInGovQuery();
```

Then inject the query object into the provider.

```php
// Instantiating a provider with a query object
$client = new JobApis\Jobs\Client\Provider\CareersInGovProvider($query);
```

And call the "getJobs" method to retrieve results.

```php
// Get a Collection of Jobs
$jobs = $client->getJobs();
```

The `getJobs` method will return a [Collection](https://github.com/jobapis/jobs-common/blob/master/src/Collection.php) of [Job](https://github.com/jobapis/jobs-common/blob/master/src/Job.php) objects.

## Testing

``` bash
$ ./vendor/bin/phpunit
```

## Contributing

Please see [CONTRIBUTING](https://github.com/jobapis/jobs-careersingov/blob/master/CONTRIBUTING.md) for details.


## Credits

- [Karl Hughes](https://github.com/karllhughes)
- [All Contributors](https://github.com/jobapis/jobs-careersingov/contributors)


## License

The Apache 2.0. Please see [License File](https://github.com/jobapis/jobs-careersingov/blob/master/LICENSE) for more information.
