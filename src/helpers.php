<?php

namespace OLIUP\PhpCS;

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

/**
 * Merge the project custom rules to our base rules.
 *
 * @param \PhpCsFixer\Finder $finder
 * @param array              $rules
 *
 * @return \PhpCsFixer\Config
 */
function mergeRules(Finder $finder, array $rules = []): Config
{
	$rules  = \array_merge(require __DIR__ . '/rules.php', $rules);
	$config = new Config();

	return $config->setFinder($finder)
				  // ->setRiskyAllowed(true) // do we really want this ? may break code
				  ->setLineEnding("\n")
				  ->setRules($rules);
}
