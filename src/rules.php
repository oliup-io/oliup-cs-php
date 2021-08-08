<?php

// this is our base rules-set
// learn more here
// https://mlocati.github.io/php-cs-fixer-configurator

return [
	'@PSR12'                                        => true,
	'@PhpCsFixer'                                   => true,
	'multiline_whitespace_before_semicolons'        => true,
	'simplified_if_return'                          => true,
	'global_namespace_import'                       => true,
	'concat_space'                                  => ['spacing' => 'one'],
	'phpdoc_tag_casing'                             => true,
	'binary_operator_spaces'                        => [
		'operators' => [
			'='  => 'align',
			'=>' => 'align',
		],
	],
];
