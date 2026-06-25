# PHP 8.5.7 Migration — `ctw/ctw-qa`

- **Branch:** `php85` (cut from `master`)
- **Runtime:** PHP 8.3.31 → **8.5.7**
- **PHPUnit:** 12 → **13.2.1**
- **Status:** ✅ done

> **This package matters most.** `ctw/ctw-qa` ships the shared QA configuration
> (`config/phpstan/common.neon`, ECS, Rector sets) that **every** other `ctw/*`
> package consumes via `ctw/ctw-qa: dev-php85`, so the PHPStan fix below
> propagates to all of them.

## Audit checklist

### `config/phpstan/common.neon`

- [x] **(tooling) `config/phpstan/common.neon`** — under PHPStan 2.2 the blanket
  `ignoreErrors` entries for `missingType.generics` / `missingType.iterableValue`
  fail with `Ignored error pattern ... was not matched in reported errors`
  whenever a consuming package has nothing to ignore (the common case), so
  `composer phpstan` / `composer qa` exit non-zero.
  - **Fix:** added `reportUnmatchedIgnoredErrors: false` so the project-wide
    blanket ignores are tolerated when unused. Restores green across this package
    and every downstream `ctw/*` package.

### Runtime

- [x] **(none)** — no runtime deprecations, warnings, or notices. The suite runs
  clean under PHP 8.5.7.

## composer.json & CI

- [x] **`require.php`** — `^8.3` → **`^8.5`**.
- [x] **`phpunit/phpunit`** — `^12.0` → **`^13.0`** (installs 13.2.1).
- [x] **`phpunit.xml.dist`** — schema bumped `12.2` → **`13.2`**.
- [x] **`.github/workflows/tests.yml`** — CI matrix pinned to PHP **`8.5`** only.

## Final audit (PHP 8.5.7)

- [x] **`php -v`** — PHP **8.5.7** (cli).
- [x] **`composer update -W`** — clean; no dependency blocked by the PHP 8.5
  platform requirement.
- [x] **PHPUnit** — **109 tests, 203 assertions**, no issues (PHPUnit 13.2.1).
- [x] **PHPStan** — `[OK] No errors` (level max).

```bash
php -v                                  # PHP 8.5.7
composer update -W                      # clean
php vendor/bin/phpunit --no-coverage    # OK (109 tests, 203 assertions)
composer phpstan                        # No issues found
```
