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
