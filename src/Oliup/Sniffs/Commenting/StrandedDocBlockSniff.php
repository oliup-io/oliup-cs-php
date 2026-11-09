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

namespace Oliup\Sniffs\Commenting;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Class StrandedDocBlockSniff.
 *
 * A docblock belongs to the declaration under it, and an edit can separate the two: a method
 * inserted before the next signature instead of after the previous closing brace, a member moved
 * while its block stays behind, a replacement written above the block it replaces. What is left is
 * a block describing nothing and, right below it, a declaration carrying a contract written for
 * something else.
 *
 * Nothing else here reports it. php-cs-fixer formats both blocks and calls the file clean, Psalm
 * reads the one attached to the declaration and has no opinion on the other, and no test fails:
 * the only symptom is documentation pointing at the wrong code, which costs more than none because
 * it is believed. It had happened 39 times across 26 files in one project before anyone looked,
 * and 6 times across three packages here, four of them written in the two days before this sniff.
 *
 * The three shapes are all cheap to recognise and all mean the same thing, so this reports the
 * shape and leaves the placing to a person: a block cannot say whether it belongs to the
 * declaration below it, which would make the fix a merge, or to one that moved away, which would
 * make it a move. A tool guessing between those two writes a wrong contract onto a real signature.
 *
 * @internal
 */
final class StrandedDocBlockSniff implements Sniff
{
	/**
	 * The closing tag of every docblock in the file.
	 *
	 * @return list<int|string>
	 */
	public function register(): array
	{
		return [T_DOC_COMMENT_CLOSE_TAG];
	}

	/**
	 * Reports the docblock when what follows it is not something a docblock can describe.
	 *
	 * @param int $stackPtr the position of the closing tag in the file's token stack
	 */
	public function process(File $phpcsFile, $stackPtr): void
	{
		$tokens = $phpcsFile->getTokens();

		// A line comment between the two does not attach the block to anything, so it is skipped
		// like whitespace. An attribute does attach it, and is a token this never reaches.
		$next = $phpcsFile->findNext([\T_WHITESPACE, \T_COMMENT], $stackPtr + 1, null, true);

		if (false === $next) {
			$phpcsFile->addError(
				'This docblock documents nothing: the file ends after it.',
				$stackPtr,
				'NothingFollows'
			);

			return;
		}

		if (T_DOC_COMMENT_OPEN_TAG === $tokens[$next]['code']) {
			$phpcsFile->addError(
				'This docblock documents nothing: another docblock follows it. Move it onto the'
					. ' declaration it describes.',
				$stackPtr,
				'AnotherDocBlockFollows'
			);

			return;
		}

		if (T_CLOSE_CURLY_BRACKET === $tokens[$next]['code']) {
			$phpcsFile->addError(
				'This docblock documents nothing: the block it is in closes after it.',
				$stackPtr,
				'CloseBraceFollows'
			);
		}
	}
}
