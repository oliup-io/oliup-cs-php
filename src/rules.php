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

// learn more here
// https://mlocati.github.io/php-cs-fixer-configurator

return [
	'@PSR12'                                 => true,
	'@PhpCsFixer'                            => true,
	'@PhpCsFixer:risky'                      => true,
	'multiline_whitespace_before_semicolons' => true,
	'simplified_if_return'                   => true,
	'global_namespace_import'                => true,
	'native_constant_invocation'             => true,
	'native_function_casing'                 => true,
	'native_function_invocation'             => [
		'include' => ['@internal'],
	],
	'concat_space'                           => ['spacing' => 'one'],
	// `new Foo()->bar()` rather than `(new Foo())->bar()`. PHP 8.4 made the wrapping parentheses
	// optional and every package here requires 8.5, so one of the two forms has to be the house one
	// or both appear side by side; this is the rule that picks, instead of each reader picking.
	'new_expression_parentheses'             => true,
	'phpdoc_tag_casing'                      => true,
	'phpdoc_to_comment'                      => false,
	'simplified_null_return'                 => false,
	'no_unset_on_property'                   => false,
	'single_line_comment_style'              => false,
	// Strips a `@param`/`@return` that only restates the signature, and keeps every one that carries a
	// description. Two sources of truth for one type is what this removes; the type stays in the code.
	'no_superfluous_phpdoc_tags'             => [
		'allow_mixed'       => false,
		'remove_inheritdoc' => true,
	],
	'binary_operator_spaces'                 => [
		'operators' => [
			'='  => 'align',
			'=>' => 'align',
		],
	],
];
