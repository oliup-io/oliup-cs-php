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
composer require oliup-io/php-cs-oliup --dev
```

## Setup PHP-CS-Fixer Finder config

Run
```shell
touch .php-cs-fixer.php
```

Your `.php-cs-fixer.php` file content should look like

```php
<?php
$finder = PhpCsFixer\Finder::create()
  ->in([
    __DIR__.'/src',
    __DIR__.'/tests',
  ]);

$rules = [
    // define your project custom rules here
];

return OLIUP\PhpCS\mergeRules($finder, $rules);

```

# You're ready!!!

Feel free to fix your code using

```shell
./vendor/bin/php-cs-fixer fix
```

# Running in CI

You could do a “dry run”, which will fail if it detects code style violations.

```shell
./vendor/bin/php-cs-fixer fix --dry-run
```
