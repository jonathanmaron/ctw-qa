# Package "ctw/ctw-qa"

[![Latest Stable Version](https://poser.pugx.org/ctw/ctw-qa/v/stable)](https://packagist.org/packages/ctw/ctw-qa)
[![GitHub Actions](https://github.com/jonathanmaron/ctw-qa/actions/workflows/ci.yml/badge.svg)](https://github.com/jonathanmaron/ctw-qa/actions/workflows/ci.yml)

Centralized, opinionated configuration for PHP 8.3+ quality assurance tools: Rector, Easy Coding Standard (ECS), and PHPStan.

## Introduction

### Why This Library Exists

Setting up quality assurance tools properly is tedious and error-prone. Each project requires configuring:

- **Rector** for code modernization (100+ lines of configuration)
- **Easy Coding Standard** for style enforcement (150+ lines)
- **PHPStan** for static analysis (50+ lines)

Multiplied across numerous projects, this becomes a maintenance burden. Configurations drift, standards diverge, and teams waste time debugging tool setups instead of writing code.

This library provides:

- **Battle-tested defaults**: Years of PHP best practices encoded in reusable configuration classes
- **PHP 8.3+ standards**: Modern PHP syntax, strict types, and property promotion
- **PSR-12 compliance**: Full adherence to PHP coding standards
- **Extensible architecture**: Override any default via class inheritance
- **Consistent tooling**: Identical QA configuration across all projects

### Problems This Library Solves

1. **Configuration drift**: Projects diverge in coding standards over time
2. **Repetitive setup**: Same boilerplate written for every new project
3. **Inconsistent quality**: Different strictness levels across codebases
4. **Maintenance burden**: Tool updates require changes in multiple places
5. **Onboarding friction**: New developers must learn project-specific configurations

### Where to Use This Library

- **New PHP projects**: Start with modern, strict standards from day one
- **Existing codebases**: Gradually modernize legacy code with Rector
- **Monorepos**: Share identical QA configuration across all packages
- **CI/CD pipelines**: Automated quality gates with consistent rules
- **Open source libraries**: Enforce professional-grade code quality

### Design Goals

1. **Opinionated defaults**: Strong opinions for modern PHP, easily overridable
2. **Invokable classes**: Simple `$config()` syntax for integration
3. **Maximum strictness**: PHPStan level `max`, strict comparisons, strict types
4. **Minimal dependencies**: Only the three QA tools themselves
5. **Extensible**: All configuration classes designed for inheritance

## Requirements

- PHP 8.3 or higher
- Composer

## Installation

Install by adding the package as a [Composer](https://getcomposer.org) requirement:

```bash
composer require ctw/ctw-qa --dev
```

## Usage Examples

### Rector Configuration

Create `rector.php` in your project root:

```php
<?php
declare(strict_types=1);

use Ctw\Qa\Rector\Config\RectorConfig\DefaultFileExtensions;
use Ctw\Qa\Rector\Config\RectorConfig\DefaultSets;
use Ctw\Qa\Rector\Config\RectorConfig\DefaultSkip;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $fileExtensions = new DefaultFileExtensions();
    $sets           = new DefaultSets();
    $skip           = new DefaultSkip();

    $rectorConfig->fileExtensions($fileExtensions());
    $rectorConfig->sets($sets());
    $rectorConfig->paths(['src', 'test']);
    $rectorConfig->skip([...$skip()]);
};
```

### ECS Configuration

Create `ecs.php` in your project root:

```php
<?php
declare(strict_types=1);

use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultFileExtensions;
use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultIndentation;
use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultLineEnding;
use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultRules;
use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultRulesWithConfiguration;
use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultSets;
use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultSkip;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\Configuration\ECSConfigBuilder;

// Wrapped in an immediately-invoked closure: ECS require()s this file in the
// scope of its container factory, where the container is held in a variable
// named $ecsConfig. Building at file scope would clobber it; the closure keeps
// every local contained.
return (static function (): ECSConfigBuilder {
    $fileExtensions = new DefaultFileExtensions();
    $indentation    = new DefaultIndentation();
    $lineEnding     = new DefaultLineEnding();
    $rules          = new DefaultRules();
    $rulesConfig    = new DefaultRulesWithConfiguration();
    $sets           = new DefaultSets();
    $skip           = new DefaultSkip();

    $ecsConfig = ECSConfig::configure()
        ->withFileExtensions($fileExtensions())
        ->withSpacing(indentation: $indentation(), lineEnding: $lineEnding())
        ->withPaths(['src', 'test'])
        ->withSets($sets())
        ->withRules($rules())
        ->withSkip($skip());

    foreach ($rulesConfig() as $checkerClass => $configuration) {
        $ecsConfig->withConfiguredRule($checkerClass, $configuration);
    }

    return $ecsConfig;
})();
```

### PHPStan Configuration

Create `phpstan.neon` in your project root:

```neon
parameters:
    level: max
    paths:
        - src
        - test
    bootstrapFiles:
        - vendor/autoload.php
```

### Composer Scripts

Add to your `composer.json`:

```json
{
    "scripts": {
        "qa": ["@rector", "@ecs", "@phpstan"],
        "qa-fix": ["@rector-fix", "@ecs-fix", "@phpstan"],
        "rector": "vendor/bin/rector process --dry-run",
        "rector-fix": "vendor/bin/rector process",
        "ecs": "vendor/bin/ecs",
        "ecs-fix": "vendor/bin/ecs --fix",
        "phpstan": "vendor/bin/phpstan analyse"
    }
}
```

Run QA checks:

```bash
composer qa        # Check everything (dry-run)
composer qa-fix    # Auto-fix everything possible
```

---

## Included Rule Sets

### Rector (Code Modernization)

| Set | Description |
|-----|-------------|
| `UP_TO_PHP_83` | Modernizes code to PHP 8.3 syntax |
| `PHPUNIT_100` | Upgrades PHPUnit to version 10.0+ |
| `CODE_QUALITY` | Simplifies expressions, removes redundancy |
| `CODING_STYLE` | Enforces consistent style |
| `DEAD_CODE` | Removes unused code |
| `NAMING` | Improves naming conventions |

### ECS (Code Style)

| Rule | Description |
|------|-------------|
| `DeclareStrictTypesFixer` | Adds `declare(strict_types=1)` |
| `DisallowLongArraySyntaxSniff` | Enforces short array syntax `[]` |
| `StrictComparisonFixer` | Enforces `===` over `==` |
| `NoUnusedImportsFixer` | Removes unused imports |
| `OrderedImportsFixer` | Alphabetizes imports |
| `TrailingCommaInMultilineFixer` | Adds trailing commas |

### PHPStan (Static Analysis)

- Level: `max` (strictest)
- Strict rules enabled
- PHPUnit extension included

---

## Customization

Extend any configuration class to modify defaults:

```php
<?php
declare(strict_types=1);

namespace App\QA;

use Ctw\Qa\Rector\Config\RectorConfig\DefaultSkip;

class CustomSkip extends DefaultSkip
{
    public function __invoke(): array
    {
        $skip = parent::__invoke();
        $skip[] = '*/legacy/*';

        return $skip;
    }
}
```

Use your custom class:

```php
$skip = new \App\QA\CustomSkip();
$rectorConfig->skip([...$skip()]);
```
