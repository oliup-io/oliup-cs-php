# oliup-cs-php

Oliup PHP coding standards - a unified code style ruleset for PHP 8.1+ projects, combining [PHP_CodeSniffer][php_codesniffer] and [PHP-CS-Fixer][php_cs_fixer].

**Includes:**

- PSR-12 + PhpCsFixer rules via PHP-CS-Fixer
- PHPCompatibility checks via PHP_CodeSniffer
- Custom Oliup whitespace, array, and safety sniffs

## Requirements

- PHP `^8.1`

## Installation

Add the VCS repository to your project's `composer.json`:

```json
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/oliup-io/oliup-cs-php"
  }
]
```

Then run:

```shell
composer require oliup/oliup-cs-php --dev
```

## Setup

Run the init command to generate config files in your project root:

```shell
vendor/bin/oliup-cs init
```

Two files will be created:

- `phpcs.xml.dist` - [PHP_CodeSniffer][php_codesniffer] config
- `.php-cs-fixer.dist.php` - [PHP-CS-Fixer][php_cs_fixer] config

> Commit both files to version control.

Adjust the `testVersion` in `phpcs.xml.dist` to match your project's minimum supported PHP version:

```xml
<config name="testVersion" value="8.1-"/>
```

## Usage

Check for code style violations:

```shell
vendor/bin/oliup-cs check
```

Automatically fix violations:

```shell
vendor/bin/oliup-cs fix
```

## CI

Dry-run fix - exits with a non-zero code if any violations are found:

```shell
vendor/bin/oliup-cs fix-ci
```

## Customizing rules

Edit `.php-cs-fixer.dist.php` to add or override PHP-CS-Fixer rules:

```php
$rules = [
    // add your project-specific rules here
];

return (new PhpCS())->mergeRules($finder, $rules)
                    ->setRiskyAllowed(true);
```

Edit `phpcs.xml.dist` to add or exclude PHP_CodeSniffer sniffs:

```xml
<ruleset>
    <file>src</file>
    <file>tests</file>
    <rule ref="vendor/oliup/oliup-cs-php/src"/>
    <config name="testVersion" value="8.1-"/>
</ruleset>
```

## Learn more

- PHP_CodeSniffer: [squizlabs/php_codesniffer][php_codesniffer]
- PHP-CS-Fixer: [friendsofphp/php-cs-fixer][php_cs_fixer] | [rule configurator][php_cs_fixer_config_creator]
- PHPCompatibility: [PHPCompatibility/PHPCompatibility](https://github.com/PHPCompatibility/PHPCompatibility)

[php_codesniffer]: https://github.com/squizlabs/php_codesniffer
[php_cs_fixer]: https://github.com/friendsofphp/php-cs-fixer
[php_cs_fixer_config_creator]: https://mlocati.github.io/php-cs-fixer-configurator
