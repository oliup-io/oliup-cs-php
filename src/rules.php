<?php

// this is our base rules-set
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
	'phpdoc_tag_casing'                      => true,
	'simplified_null_return'                 => false,
	'no_unset_on_property'                   => false,
	'single_line_comment_style'              => false,
	'no_superfluous_phpdoc_tags'             => false,
	'binary_operator_spaces'                 => [
		'operators' => [
			'='  => 'align',
			'=>' => 'align',
		],
	],
];
