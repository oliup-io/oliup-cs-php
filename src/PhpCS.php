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
