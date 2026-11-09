# Changelog

This file starts after `v1.0.3`. What came before it is the repository's tags and their history.

## Unreleased (1.x-dev)

### Breaking changes

- **PHP 8.5 is the minimum** (`"php": ">=8.5"`, was `>=7.2`), with `config.platform.php` pinned to
  `8.5.12`, and the tools move with it: `squizlabs/php_codesniffer` `^4.0` (was `>=3.13`),
  `phpcompatibility/php-compatibility` `^10.0@alpha` (was `>=9.3`) and `friendsofphp/php-cs-fixer`
  `^3.94` as a caret rather than an open floor. The PHPCompatibility target (`testVersion`) is
  `8.5-`. A package still below 8.5 stays on `v1.0.3`.

- **`composer.json` no longer carries a `version`**, and declares `dev-main` as `1.x-dev` instead:
  a hardcoded version in the package and a tag are two sources of truth, and the tag is the one
  Composer should read.

- **`PhpCS::mergeRules()` returns `static`**, not `self`.

### Added

- **A docblock separated from its declaration is an error**
  (`Oliup.Commenting.StrandedDocBlock`, `src/Oliup/Sniffs/Commenting/StrandedDocBlockSniff.php`),
  the first sniff of this standard's own. It reports a docblock followed by another docblock, by
  the closing brace of the block it sits in, or by nothing: three shapes of the same fault, a block
  describing nothing with a declaration under it carrying a contract written for something else.
  Nothing else reports it. php-cs-fixer formats both blocks and calls the file clean, psalm reads
  the attached one and has no opinion on the other, and no test fails, so what is left is
  documentation pointing at the wrong code, which costs more than none because it is believed.

  It is reported, never fixed: a block cannot say whether it belongs to the declaration below it,
  which would make the fix a merge, or to one that moved away, which would make it a move, and a
  tool guessing between those two writes a wrong contract onto a real signature. The counts when it
  was added: `ozone` 10, `gobl` 1, `blate` 1, every other package 0, all twelve from a member
  inserted above a block instead of below the closing brace before it. Per line,
  `// phpcs:ignore Oliup.Commenting.StrandedDocBlock` where a file really means it.

  Two of ozone's twelve were a pair of stacked `/** @var */` annotations, where only the lower one
  attaches to the statement, and placing each on the statement it types uncovered a `TypeError` in
  production code that the ignored annotation had kept from the analyser for five releases. That is
  the cost this sniff is for: the shape is cheap to see and what it hides is not.

  The sniffs live in a nested standard, `src/Oliup/`, because phpcs resolves a sniff's class from
  its directory: a sniff under `src/` would have to be named `src\Sniffs\...`. A package needs no
  configuration for them, since it already points phpcs at `vendor/oliup/oliup-cs-php/src`, and
  that directory is excluded from the classmap (`autoload.exclude-from-classmap`) because the
  namespace is the standard's, not the package's.

- **A `null` passed into a parameter that is not nullable is an error**
  (`PossiblyNullArgument`, `src/psalm/handlers.xml`). It is the one check raised while the packages
  still have occurrences of it, and the reason is what it costs when it is only information: under
  strict types it is a `TypeError` at the first call that takes that branch, in production. One
  shipped that way in blate, whose refusal of a template extending itself compared a path against
  the template's own, which is null for a template compiled from a string; the analyser had printed
  the file, the line and the column, at a level that reads as noise.

  A package fails this gate the moment its own lock takes this file, which is each package's own
  moment and not a flag day. The counts when it was raised: `kli` 1, `code-generator` 1,
  `php-utils` 4, `blate` 9, `ozone` 50, `gobl` 62, `ozone-oweb` 0. No baseline, for the reason this
  config has none anywhere: a baseline is a list nobody reads, and the next occurrence joins it in
  silence. `PossiblyFalseArgument`, the other half of what level 3 would add, stays off.

- **The static analysis levels are one file every package includes**: `src/psalm/handlers.xml`,
  pulled into a package's `psalm.xml` from `vendor/` with
  `<xi:include href="vendor/oliup/oliup-cs-php/src/psalm/handlers.xml"/>` on a config carrying
  `xmlns:xi="http://www.w3.org/2001/XInclude"`. It raises to `error` the 22 `Possibly*`,
  `RiskyCast` and `NonInvariantDocblockPropertyType` issues, plus `NullArrayOffset` and
  `PossiblyNullArrayOffset`, which PHP 8.5 deprecates in every form; and it suppresses what a
  library cannot answer for (an unused public method, parameter, property or return value, an
  unused class) and what psalm infers wrongly often enough to be noise. A package keeps its own
  `<issueHandlers>` block beside the include for what is its own alone: both blocks are read.
  Nothing a package declares locally is a copy of what is shared, which is how seven packages came
  to analyse at seven different levels.

- **The tool versions are one floor every package inherits**, as a `conflict` block: a package that
  requires `oliup/oliup-cs-php` cannot resolve `phpunit/phpunit` below 13.4 or `vimeo/psalm`
  below 6.0, and Composer names this package in the refusal. `conflict` installs nothing, so each
  package still declares the tools it uses itself; only the floor is shared. `php` needs no entry,
  since `require` already refuses a lower install.

- **`php_unit_attributes`**: a PHPUnit annotation is rewritten as an attribute. PHPUnit 13 reads no
  doc-comment metadata and reports none it finds, so a `@dataProvider` left behind makes a test run
  with no arguments and a `@group` makes a `--group` selection match nothing. The attribute is the
  only form that works, and this is what keeps a new test from using the other.

- **`new_expression_parentheses`**: `new Foo()` keeps its parentheses, which PHP 8.4's
  `new Foo()->bar()` needs anyway.

- **`@PHP8x5Migration` and `@PHP8x5Migration:risky`**: the floor moved to PHP 8.5 and nothing
  followed it, so every file kept the syntax of the year it was written. The two sets write the
  current one: `$x::class` over `get_class($x)`, `0o755` over `0755`, an arrow function over a
  closure that only returns, a heredoc indented with the code around it. Risky was already the
  house default (`@PhpCsFixer:risky`, and `setRiskyAllowed(true)` in every repository's config), and
  the rules that matter here are in the risky half, so both sets are on.

- **`no_superfluous_phpdoc_tags`** is on, with `remove_inheritdoc`: a `@param` or `@return` that
  only restates the signature is stripped, and one carrying a description is kept. Two sources of
  truth for one type is what this removes; the type stays in the code.

### Fixed

- The sniffs that contradicted php-cs-fixer are silenced instead of making the two tools undo each
  other's work: an empty body on the declaration line, `catch (A|B $e)`, `new class(...)` and a
  multi-line condition starting on the `if (` line.
- `Generic.WhiteSpace.LanguageConstructSpacing` replaces the `Squiz` sniff of that name, which
  phpcs 4 no longer has.
- Two PHPCompatibility false positives are silenced by name: a `sqlite()` method is not the removed
  `ext/sqlite`, and an interface may extend `BackedEnum`.
- A test may keep a small helper class next to the test that uses it
  (`PSR1.Classes.ClassDeclaration.MultipleClasses` excluded under `tests/`).
- This package's own code style run fails on errors only: warnings, which are mostly line length,
  are reported without setting a non-zero exit (`ignore_warnings_on_exit` in `phpcs.xml.dist`). A
  package wanting the same sets it in its own configuration; the shared `ruleset.xml` does not
  decide it.
