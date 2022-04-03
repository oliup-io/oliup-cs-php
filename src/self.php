<?php

/**
 * PHP CS Fixer configs for this repo.
 */

use OLIUP\CS\PhpCS;
use PhpCsFixer\Finder;

$finder = Finder::create();

$finder->in([
	__DIR__,
])
->ignoreDotFiles(true)
->ignoreVCS(true);

$rules = [
	// define your project custom rules here
];

return (new PhpCS())->mergeRules($finder, $rules)
	->setRiskyAllowed(true);
