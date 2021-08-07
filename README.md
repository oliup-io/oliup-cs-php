# Oliup PHP code style rules helper

You need to add this to your project `composer.json` file.

```
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/oliup-io/php-cs-oliup"
  }
]
```

# Installation

Run

```shell
composer require oliup/php-cs-oliup --dev
```

# Setup

## For automatic setup

Run

```shell
./vendor/bn/php-cs-oliup
```

## Manual setup

### Setup [PHP Code Sniffer][php_codesniffer] config

Run

```shell
touch phpcs.xml.dist
```

Your `phpcs.xml.dist` file content should look like

```xml
<?xml version="1.0"?>
<ruleset>
    <!-- Files or folders to sniff -->
    <file>src</file>
    <file>tests</file>

    <!-- Path to our coding standard folder -->
    <rule ref="vendor/oliup/php-cs-oliup/src"/>
</ruleset>

```

### Setup [PHP-CS-Fixer][php_cs_fixer] config

Run

```shell
touch .php-cs-fixer.php
```

Your `.php-cs-fixer.php` file content should look like

```php
<?php

use OLIUP\PhpCS\PhpCS;
use PhpCsFixer\Finder;

$finder = Finder::create();

$finder->in([
	__DIR__ . '/src',
	__DIR__ . '/tests',
]);

$rules = [
	// define your project custom rules here
];

return (new PhpCS())->mergeRules($finder, $rules)
					->setRiskyAllowed(true);

```

# You're ready!!!

To checks code style run:

```shell
./vendor/bin/phpcs
```

To fix your code run:

```shell
./vendor/bin/php-cs-fixer fix --using-cache=no
```

# Running in CI

You could do a “dry run”, which will fail if it detects code style violations.

```shell
./vendor/bin/php-cs-fixer fix --using-cache=no --dry-run
```

[php_codesniffer]: https://github.com/squizlabs/php_codesniffer
[php_cs_fixer]: https://github.com/friendsofphp/php-cs-fixer
