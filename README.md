# Oliup PHP code style rules helper

You need to add this to your project `composer.json` file.

```
"repositories": [
  {
    "type": "vcs",
    "url": "https://github.com/oliup-io/oliup-cs-php"
  }
]
```

# Installation

Run

```shell
composer require oliup/oliup-cs-php --dev
```

# Setup

Run

```shell
vendor/bin/oliup-cs init
```

Two file will be created:

- `phpcs.dist.xml` [PHP Code Sniffer][php_codesniffer] config
- `.php-cs-fixer.dist.php` [PHP-CS-Fixer][php_cs_fixer] config

> Both `phpcs.dist.xml` and `.php-cs-fixer.dist.php` files should be committed to git.

You're ready!!!

To checks code style run:

```shell
vendor/bin/oliup-cs check
```

To fix your code run:

```shell
vendor/bin/oliup-cs fix
```

# Running in CI

You could do a “dry run”, which will fail if it detects code style violations.

```shell
vendor/bin/oliup-cs fix-ci
```

# Learn more

PHP Code Sniffer: [repo][php_codesniffer]

PHP CS Fixer: [repo][php_cs_fixer] | [config creator][php_cs_fixer_config_creator]

[php_codesniffer]: https://github.com/squizlabs/php_codesniffer
[php_cs_fixer]: https://github.com/friendsofphp/php-cs-fixer
[php_cs_fixer_config_creator]: https://mlocati.github.io/php-cs-fixer-configurator
