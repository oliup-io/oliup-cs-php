<?php

/**
 * Copyright (c) 2021-present, Oliup
 *
 * This file is part of OLIUP CS package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use OLIUP\CS\PhpCS;
use PhpCsFixer\Finder;

$finder = Finder::create();

$finder->in([
	__DIR__,
])
	->ignoreDotFiles(true)
	->ignoreVCS(true);

$header = <<<'EOF'
Copyright (c) 2021-present, Oliup

This file is part of OLIUP CS package.

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

$rules = [
	'header_comment' => [
		'header'       => $header,
		'comment_type' => 'PHPDoc',
		'separate'     => 'both',
		'location'     => 'after_open',
	],
];

return (new PhpCS())->mergeRules($finder, $rules)
	->setRiskyAllowed(true);
