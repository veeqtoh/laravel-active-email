# laravel-active-email

<p align="center">
<a href="https://packagist.org/packages/veeqtoh/laravel-active-email"><img src="https://img.shields.io/packagist/v/veeqtoh/laravel-active-email?style=flat-square" alt="Latest Version on Packagist"></a>
<a href="https://packagist.org/packages/veeqtoh/laravel-active-email"><img src="https://img.shields.io/packagist/dt/veeqtoh/laravel-active-email?style=flat-square" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/veeqtoh/laravel-active-email"><img src="https://img.shields.io/packagist/php-v/veeqtoh/laravel-active-email?style=flat-square" alt="PHP from Packagist"></a>
<a href="https://github.com/veeqtoh/laravel-active-email/blob/master/LICENSE"><img src="https://img.shields.io/github/license/veeqtoh/laravel-active-email?style=flat-square" alt="GitHub license"></a>
</p>

## Table of Contents

- [Overview](#overview)
    - [Key Features](#key-features)
- [Installation](#installation)
    - [Requirements](#requirements)
    - [Install the Package](#install-the-package)
    - [Publish the Config](#publish-the-config)
- [Usage](#usage)
    - [Validator Approach](#validator-approach)
    - [Class Approach](#class-approach)
    - [Customization](#customization)
        - [Strict Mode](#strict-mode)
        - [Black List](#black-list)
        - [Grey List](#grey-list)
        - [White List](#white-list)
- [Testing](#testing)
- [To do](#to-do)
- [Security](#security)
- [Contribution](#contribution)
- [Changelog](#changelog)
- [Upgrading](#upgrading)
- [License](#license)

## Overview

This package provides a library of disposable domains and adds a validator to Laravel apps to check that a given email address isn't coming from a disposable email service such as `Mailinator`, `Guerillamail`, `Fastmail` considering all their possible wildcards.

### Key Features

- You can add your own preferred domains to the [black list](#black-list).
- You can [white list](#white-list) a domain to bye pass the blacklist. This can be useful in development environment.
- With [strict mode](#strict-mode), you can control the strictness of the validator, thereby allowing or preventing domains that are not necessarily disposable, but have been classified as disposable.
- Case-aware.
- Wildcard-aware.

## Installation


### Requirements

The package has been developed and tested to work with the following minimum requirements:

- PHP 8.x
- Laravel 10.x, 11.x

### Install the Package

You can install the package via Composer. The service provider is discovered automatically.

```bash
composer require veeqtoh/laravel-active-email
```

### Publish the Config

You can then publish the package's config file and update it as you'd prefer:
```bash
php artisan vendor:publish --provider="Veeqtoh\ActiveEmail\Providers\ActiveEmailProvider"
```

## Usage

### Validator Approach

Add the `notblacklisted` validator to your email validation rules array (or string) to ensure that the domain for a given email address is not blacklisted. I'd recommend you add it after the email validator to make sure a valid email is passed through:
```php
'emailField' => 'email|notblacklisted',
```

or

```php
'emailField' => ['email', 'notblacklisted'],
```

### Class Approach

Instantiate the `NotBlackListedEmail` Class as part of your email validation rules array to ensure that the domain for a given email address is not blacklisted. Again, I'd recommend you add it after the email validator to make sure a valid email is passed through:

```php
use Veeqtoh\ActiveEmail\Rules\NotBlackListedEmail;

'emailField' => ['email', new NotBlackListedEmail()],
```

### Customization

The package is highly customizable from the config file with the following features:

#### Strict Mode

This value determines the strictness level of this feature. when set to `true`, domains in the [grey list](#grey-list) are also blacklisted.

It is turned on by default, but can be set in your .env file as follows:

```php
DISPOSABLE_EMAIL_STRICT_MODE=true,
```

#### Black List

This is a list of base domains with or without the TLD that are blacklisted by default. Add a domain to this list to blacklist it.

#### Grey List

This is a list of base domains with or without the TLD that aren't blacklisted by default except when in strict mode. Add a domain to this list to whitelist it when the feature is not set to strict mode. Ensure that the domain is not on the [black list](#black-list).

#### White List

This is a list of base domains with or without the TLD that are blacklisted by default but you want them to be bye passed.

## To Do

There's always something that can be done to improve this package. I'd keep updating this list as I think of them.

- Crawl the web to grab an updated list of disposable domains.
- Maybe setup a schedule for it..

## Testing

To run the package's unit tests, run the following command:

``` bash
vendor/bin/pest
```

## Security

If you find any security related issues, please contact me directly at [victorjohnukam@gmail.com](mailto:victorjohnukam@gmail.com) to report it.

## Contribution

If you wish to make any changes or improvements to the package, feel free to make a pull request.

Note: A contribution guide will be added soon.

## Changelog

Check the [CHANGELOG](CHANGELOG.md) to get more information about the latest changes.

## Upgrading

Check the [UPGRADE](UPGRADE.md) guide to get more information on how to update this library to newer versions.

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

## Support Me

If you've found this package useful, please consider [sponsoring this project](https://github.com/sponsors/veeqtoh). It will encourage me to keep maintaining it.
