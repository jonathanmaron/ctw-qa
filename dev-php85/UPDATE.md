# PHP 8.5.7 Upgrade — `ctw/ctw-qa`

- **Branch:** `php85` (cut from `master`)
- **Runtime:** PHP 8.3.31 → **8.5.7**
- **Date:** 2026-06-25

This is a **TODO list** of the changes required for this package to run cleanly
under PHP 8.5.7. Nothing here has been fixed yet — the fixes happen in a second
step. Boxes are intentionally left unchecked.

> **This package matters most.** `ctw/ctw-qa` ships the shared QA configuration
> (`config/phpstan/common.neon`, ECS, Rector sets) that **every** other `ctw/*`
> package includes. The PHPStan issue below is therefore the root cause of the
> identical PHPStan failures reported in the other packages' `UPDATE.md` files.
> Fix it here first.

Detection commands used:

```bash
composer update -W
php vendor/bin/phpunit --no-coverage --display-deprecations --display-warnings --display-notices --display-errors
composer rector      # rector --dry-run
composer phpstan
```

---

## 1. `composer update -W`

✅ **Succeeded.** No dependency was blocked by an incompatible PHP 8.5 platform
requirement.

Notable upgrades:

| Package | From | To |
| --- | --- | --- |
| `phpstan/phpstan` | 2.1.54 | 2.2.2 |
| `phpunit/phpunit` | 12.5.25 | 12.5.30 |
| `rector/rector` | 2.4.3 | 2.5.2 |
| `symplify/easy-coding-standard` | 13.1.3 | 13.2.3 |

`composer.lock` is git-ignored, so the update produces no committed diff — only
this report is committed on the `php85` branch.

---

## 2. PHP 8.5 runtime issues (must fix)

- **None.** The test suite runs clean under PHP 8.5.7 — 109 tests, 203
  assertions, no deprecations / warnings / notices.

---

## 3. QA tooling issues (surfaced by the dependency update) — **fix here, affects all packages**

- [ ] **`config/phpstan/common.neon:15-19`** — PHPStan **2.2** is stricter about
  unmatched ignore patterns (`reportUnmatchedIgnoredErrors` defaults to `true`).
  The shared `ignoreErrors` entries

  ```neon
  ignoreErrors:
      - identifier: missingType.generics
      - identifier: missingType.iterableValue
  ```

  now raise `Ignored error pattern missingType.generics was not matched in
  reported errors.` whenever a consuming package has no missing-generics error
  to ignore (which is the common case). PHPStan exits non-zero (`composer
  phpstan` / `composer qa` fail).

  **Fix options (decide in step 2):**
  1. Add `reportUnmatchedIgnoredErrors: false` to `common.neon` so these
     "blanket" ignores are tolerated when unused — simplest, restores green
     across all packages; or
  2. Convert the two entries to non-failing form, e.g.
     `treatPhpDocTypesAsCertain`/`reportUnmatched*` per-identifier handling; or
  3. Drop the blanket ignores and let each package carry its own.

  Option 1 is recommended because the patterns are intended as project-wide
  blanket suppressions.

---

## 4. Notes (non-blocking, not PHP 8.5 specific)

- Running `php vendor/bin/phpunit` with the project config can report
  **"No tests executed!"** locally because `phpunit.xml.dist` configures a
  `<coverage>` report but no coverage driver (Xdebug/PCOV) is installed on this
  machine. Use `--no-coverage` locally; CI has a driver. Not a PHP 8.5
  regression.

---

## 5. Verification snapshot (current state on `php85`)

| Check | Result |
| --- | --- |
| `composer update -W` | ✅ clean |
| PHPUnit (`--no-coverage`) | ✅ 109 tests, 203 assertions, 0 issues |
| Rector (dry-run) | ✅ no changes proposed |
| PHPStan | ❌ 1 error (unmatched ignore pattern, see §3) |

Once §3 is addressed this package — and the shared config it exports — is green
under PHP 8.5.7.
