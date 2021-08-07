<?php

/**
 * PHP CS Fixer configs for this repo.
 */

use OLIUP\PhpCS\PhpCS;
use PhpCsFixer\Finder;

$finder = Finder::create();

$finder->in([
	__DIR__
]);

$rules = [
	// define your project custom rules here
];

return (new PhpCS())->mergeRules($finder, $rules)
					->setRiskyAllowed(true);
