<?php

namespace OLIUP\PhpCS;

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

/**
 * Class PhpCS
 *
 * @package OLIUP\PhpCS
 */
class PhpCS extends Config
{
	/**
	 * Merge the project custom rules to our base rules.
	 *
	 * @param \PhpCsFixer\Finder $finder
	 * @param array              $rules
	 *
	 * @return $this
	 */
	public function mergeRules(Finder $finder, array $rules = []): self
	{
		$rules  = \array_merge(require __DIR__ . '/rules.php', $rules);

		$this->setFinder($finder)
					  ->setIndent("\t")
					  ->setLineEnding("\n")
					  ->setRules($rules);

		return $this;
	}
}
