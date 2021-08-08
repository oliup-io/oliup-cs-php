<?php

namespace OLIUP\CS;

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

/**
 * Class PhpCS.
 */
class PhpCS extends Config
{
	/**
	 * Merge the project custom rules to our base rules.
	 *
	 * @return $this
	 */
	public function mergeRules(Finder $finder, array $rules = []): self
	{
		$rules = \array_merge(require __DIR__ . '/rules.php', $rules);

		$this->setFinder($finder)
			->setIndent("\t")
			->setLineEnding("\n")
			->setRules($rules);

		return $this;
	}
}
