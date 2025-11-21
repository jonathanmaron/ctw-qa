# CTW Quality Assurance (QA) Configuration

[![PHP Version](https://img.shields.io/badge/PHP-8.3%2B-blue.svg)](https://www.php.net/)
[![License](https://img.shields.io/badge/license-proprietary-red.svg)]()

A comprehensive PHP package that provides centralized, opinionated configuration for modern PHP quality assurance tools. Stop configuring the same tools over and over across multiple projects—use battle-tested defaults that enforce PHP 8.3+ best practices.

## Table of Contents

- [What Does This Package Do?](#what-does-this-package-do)
- [Why Use This Package?](#why-use-this-package)
- [The QA Tools](#the-qa-tools)
- [Requirements](#requirements)
- [Installation](#installation)
- [Quick Start](#quick-start)
- [Usage](#usage)
  - [Using Rector](#using-rector)
  - [Using Easy Coding Standard](#using-easy-coding-standard)
  - [Using PHPStan](#using-phpstan)
- [Configuration Details](#configuration-details)
- [Customizing Configurations](#customizing-configurations)
- [Running QA Checks](#running-qa-checks)
- [What Gets Checked?](#what-gets-checked)
- [Testing](#testing)
- [Project Structure](#project-structure)
- [Contributing](#contributing)
- [License](#license)

---

## What Does This Package Do?

This package provides **pre-configured, production-ready settings** for three essential PHP quality assurance tools:

1. **Rector** - Automated code refactoring and modernization
2. **Easy Coding Standard (ECS)** - Code style enforcement and automatic fixing
3. **PHPStan** - Static code analysis for type safety

Instead of manually configuring each tool in every project, you get:
- ✅ Opinionated defaults that enforce modern PHP 8.3+ standards
- ✅ PSR-12 compliant code formatting
- ✅ Strict type checking and enforcement
- ✅ Consistent configuration across all your projects
- ✅ Easily customizable through class inheritance

---

## Why Use This Package?

### The Problem

Setting up quality assurance tools properly is tedious:

```php
// Without this package, you need to configure each tool separately:
// - rector.php (100+ lines)
// - ecs.php (150+ lines)
// - phpstan.neon (50+ lines)
// And you have to do this for EVERY project... 😩
```

### The Solution

```php
// With this package:
use Ctw\Qa\Rector\Config\RectorConfig\DefaultSets;

$sets = new DefaultSets();
$rectorConfig->sets($sets()); // Done! ✨
```

This package encapsulates years of PHP best practices into reusable configuration classes that you can use immediately or extend to fit your specific needs.

---

## The QA Tools

Understanding what each tool does helps you use them effectively:

### 🔧 Rector - The Code Modernizer

**What it does**: Automatically upgrades your code to modern PHP syntax and patterns.

**Example transformations**:
```php
// Before (PHP 7.x style)
class User {
    private $name;

    public function __construct($name) {
        $this->name = $name;
    }
}

// After (PHP 8.3 style - Rector does this automatically!)
class User {
    public function __construct(
        private readonly string $name
    ) {}
}
```

**When to run**: After pulling code, before committing, during major refactoring.

---

### 🎨 Easy Coding Standard (ECS) - The Code Stylist

**What it does**: Enforces consistent code formatting and style across your entire codebase.

**Example fixes**:
```php
// Before (inconsistent style)
class Example{
    function test( $arg ){
        if($arg==true){return "yes";}
    }
}

// After (PSR-12 compliant)
class Example
{
    public function test(mixed $arg): string
    {
        if (true === $arg) {
            return 'yes';
        }
    }
}
```

**When to run**: Before every commit, in CI/CD pipelines.

---

### 🔍 PHPStan - The Type Safety Guardian

**What it does**: Analyzes your code without running it to find type errors, bugs, and inconsistencies.

**Example checks**:
```php
class Calculator
{
    public function add(int $a, int $b): int
    {
        return $a + $b;
    }
}

$calc = new Calculator();
$result = $calc->add(5, "10"); // ❌ PHPStan catches this: string passed instead of int
```

**When to run**: During development, before merging PRs, in CI/CD.

---

## Requirements

- **PHP**: ^8.3
- **Composer**: Latest version recommended
- **Xdebug** (optional): For code coverage reports

---

## Installation

Install via Composer:

```bash
composer require ctw/ctw-qa --dev
```

> **Note**: This should be a development dependency since it's used for code quality checks, not in production.

---

## Quick Start

After installation, you can immediately use the pre-configured QA tools.

### 1️⃣ Create Configuration Files

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

return static function (ECSConfig $ecsConfig): void {
    $fileExtensions = new DefaultFileExtensions();
    $indentation    = new DefaultIndentation();
    $lineEnding     = new DefaultLineEnding();
    $rules          = new DefaultRules();
    $rulesConfig    = new DefaultRulesWithConfiguration();
    $sets           = new DefaultSets();
    $skip           = new DefaultSkip();

    $ecsConfig->fileExtensions($fileExtensions());
    $ecsConfig->indentation($indentation());
    $ecsConfig->lineEnding($lineEnding());
    $ecsConfig->paths(['src', 'test']);
    $ecsConfig->sets($sets());
    $ecsConfig->rules($rules());
    $ecsConfig->rulesWithConfiguration($rulesConfig());
    $ecsConfig->skip($skip());
};
```

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

### 2️⃣ Run QA Tools

```bash
# Check what Rector would change (dry run)
vendor/bin/rector process --dry-run

# Apply Rector changes automatically
vendor/bin/rector process

# Check code style with ECS
vendor/bin/ecs

# Fix code style automatically
vendor/bin/ecs --fix

# Run PHPStan analysis
vendor/bin/phpstan analyse
```

### 3️⃣ Add to Composer Scripts

Add these to your `composer.json` for convenience:

```json
{
    "scripts": {
        "qa": [
            "@rector",
            "@ecs",
            "@phpstan"
        ],
        "qa-fix": [
            "@rector-fix",
            "@ecs-fix",
            "@phpstan"
        ],
        "rector": "vendor/bin/rector process --dry-run",
        "rector-fix": "vendor/bin/rector process",
        "ecs": "vendor/bin/ecs",
        "ecs-fix": "vendor/bin/ecs --fix",
        "phpstan": "vendor/bin/phpstan analyse"
    }
}
```

Now run QA checks with:

```bash
composer qa        # Check everything
composer qa-fix    # Auto-fix everything possible
```

---

## Usage

### Using Rector

#### What's Included

The default Rector configuration includes **6 powerful rule sets**:

1. **UP_TO_PHP_83** - Modernizes code to PHP 8.3 syntax
   - Property promotion in constructors
   - Named arguments
   - Match expressions
   - Nullsafe operator
   - And much more!

2. **PHPUNIT_100** - Upgrades PHPUnit to version 10.0+
   - Modern assertion syntax
   - Attribute-based configuration
   - Updated test patterns

3. **CODE_QUALITY** - Improves code quality
   - Simplifies complex expressions
   - Removes redundant code
   - Optimizes performance patterns

4. **CODING_STYLE** - Enforces consistent style
   - Return type declarations
   - Visibility modifiers
   - Class organization

5. **DEAD_CODE** - Removes unused code
   - Unreachable statements
   - Unused variables
   - Dead private methods

6. **NAMING** - Improves naming conventions
   - Consistent variable names
   - Better method names

#### Configuration Classes

```php
use Ctw\Qa\Rector\Config\RectorConfig\DefaultFileExtensions;  // ['php', 'phtml']
use Ctw\Qa\Rector\Config\RectorConfig\DefaultSets;             // 6 rule sets above
use Ctw\Qa\Rector\Config\RectorConfig\DefaultSkip;             // Directories and rules to skip
```

#### What Gets Skipped

The default skip configuration excludes:
- **Directories**: `*/build/*`, `*/compiled/*`, `*/doc/*`, `*/docs/*`, `*/node_modules/*`, `*/vendor/*`
- **Specific Rules**:
  - `NullToStrictStringFuncCallArgRector` (can be too aggressive)
  - Three naming rules that may conflict with domain naming
  - `NewlineAfterStatementRector` for `.phtml` files

---

### Using Easy Coding Standard

#### What's Included

The default ECS configuration includes **5 rule sets** plus **12 specific rules**:

**Rule Sets:**
1. **CLEAN_CODE** - Clean code principles
2. **COMMON** - Common PHP-CS-Fixer rules
3. **PSR_12** - Full PSR-12 compliance
4. **STRICT** - Strict type enforcement
5. **SYMPLIFY** - Symplify-specific improvements

**Enforced Rules:**
- ✅ `declare(strict_types=1)` in every file
- ✅ Short array syntax `[]` instead of `array()`
- ✅ Strict comparisons `===` instead of `==`
- ✅ No unused imports
- ✅ Alphabetically ordered traits
- ✅ Consistent PHPDoc type ordering
- ✅ Trailing commas in multiline arrays
- ✅ Yoda style comparisons (`value === constant`)
- ✅ Alphabetically ordered imports (classes, functions, constants)

#### Configuration Classes

```php
use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultFileExtensions;           // ['php', 'phtml']
use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultIndentation;              // 'spaces'
use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultLineEnding;               // "\n" (Unix)
use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultRules;                    // 9 fixers
use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultRulesWithConfiguration;   // 3 configured rules
use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultSets;                     // 5 rule sets
use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultSkip;                     // Skip patterns
```

#### What Gets Skipped

- **Directories**: Same as Rector
- **Specific Fixers**: Rules that conflict with other standards or are too opinionated

---

### Using PHPStan

#### What's Included

- **Analysis Level**: `max` (strictest possible - level 9)
- **Parallel Processing**: Up to 256 processes for fast analysis
- **File Support**: `.php` and `.phtml` files
- **Timeout**: 240 seconds per process

#### Key Features

The configuration enables maximum strictness:
- Type inference and checking
- Dead code detection
- Strict comparisons
- Array type verification
- Property type validation
- Method return type checking

---

## Configuration Details

All configuration classes follow the **Invokable Pattern**. This means you call them like functions:

```php
$sets = new DefaultSets();
$result = $sets();  // Returns an array of configuration values
```

### File Extensions

Both Rector and ECS process:
- `.php` files
- `.phtml` files (PHP templates)

### Code Style Standards

#### Indentation
```php
$indentation = new DefaultIndentation();
echo $indentation(); // "spaces"
```
Uses **4 spaces** per indentation level (PSR-12 standard).

#### Line Endings
```php
$lineEnding = new DefaultLineEnding();
echo $lineEnding(); // "\n"
```
Uses **Unix line endings** (`\n`) - compatible with Git auto-conversion.

#### Comparisons

**Yoda Style** is enforced for safety:
```php
// Good ✅
if (42 === $answer) {
    // comparison
}

// Bad ❌
if ($answer === 42) {
    // might accidentally use assignment (=)
}
```

#### Strict Types

Every PHP file must start with:
```php
<?php

declare(strict_types=1);
```

This is automatically enforced and added by ECS.

---

## Customizing Configurations

All configuration classes can be extended to fit your needs:

### Example: Adding Custom Rector Rules

```php
<?php

declare(strict_types=1);

namespace App\QA\Config;

use Ctw\Qa\Rector\Config\RectorConfig\DefaultSets;
use Rector\TypeDeclaration\Rector\Property\TypedPropertyFromStrictConstructorRector;

class CustomRectorSets extends DefaultSets
{
    public function __invoke(): array
    {
        // Get all default sets
        $sets = parent::__invoke();

        // Add your custom sets or rules
        $sets[] = TypedPropertyFromStrictConstructorRector::class;

        return $sets;
    }
}
```

Then use your custom class:

```php
// In rector.php
$sets = new CustomRectorSets();  // Your extended class
$rectorConfig->sets($sets());
```

### Example: Customizing Skip Patterns

```php
<?php

declare(strict_types=1);

namespace App\QA\Config;

use Ctw\Qa\Rector\Config\RectorConfig\DefaultSkip;

class CustomSkip extends DefaultSkip
{
    public function __invoke(): array
    {
        $skip = parent::__invoke();

        // Add your own directories to skip
        $skip[] = '*/legacy/*';
        $skip[] = '*/generated/*';

        return $skip;
    }
}
```

### Example: Additional ECS Rules

```php
<?php

declare(strict_types=1);

namespace App\QA\Config;

use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultRules;
use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;

class CustomEcsRules extends DefaultRules
{
    public function __invoke(): array
    {
        $rules = parent::__invoke();

        // Add additional rules
        $rules[] = ArraySyntaxFixer::class;

        return $rules;
    }
}
```

---

## Running QA Checks

### Recommended Workflow

Follow this order for best results:

```bash
# 1. Run Rector (modernize code structure)
composer rector-fix

# 2. Run ECS (fix code style)
composer ecs-fix

# 3. Run PHPStan (verify type safety)
composer phpstan
```

### Integration with Git Hooks

Add a pre-commit hook (`.git/hooks/pre-commit`):

```bash
#!/bin/bash

echo "Running QA checks..."

# Run checks
composer ecs || exit 1
composer phpstan || exit 1

echo "✅ QA checks passed!"
exit 0
```

Make it executable:
```bash
chmod +x .git/hooks/pre-commit
```

### CI/CD Integration

Example GitHub Actions workflow:

```yaml
name: QA

on: [push, pull_request]

jobs:
  qa:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v3

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'
          coverage: xdebug

      - name: Install dependencies
        run: composer install --prefer-dist

      - name: Run Rector
        run: composer rector

      - name: Run ECS
        run: composer ecs

      - name: Run PHPStan
        run: composer phpstan
```

---

## What Gets Checked?

### ✅ Code Modernization (Rector)

- [ ] PHP 8.3 syntax usage
- [ ] Constructor property promotion
- [ ] Match expressions instead of switch
- [ ] Nullsafe operator usage
- [ ] Named arguments support
- [ ] Readonly properties
- [ ] Enums usage where appropriate
- [ ] Modern PHPUnit assertions
- [ ] Dead code removal
- [ ] Code quality improvements

### ✅ Code Style (ECS)

- [ ] PSR-12 compliance
- [ ] `declare(strict_types=1)` present
- [ ] Short array syntax `[]`
- [ ] Strict comparisons `===`
- [ ] No unused imports
- [ ] Alphabetically ordered imports
- [ ] Consistent indentation (4 spaces)
- [ ] Unix line endings `\n`
- [ ] Trailing commas in multiline
- [ ] Yoda comparisons
- [ ] Proper PHPDoc formatting

### ✅ Type Safety (PHPStan)

- [ ] All properties have types
- [ ] All methods have return types
- [ ] All parameters have types
- [ ] No type mismatches
- [ ] No undefined variables
- [ ] No undefined methods/properties
- [ ] Correct array types
- [ ] Correct nullable handling
- [ ] No dead code paths
- [ ] Correct variable assignments

---

## Testing

This package includes comprehensive unit tests for all configuration classes.

### Running Tests

```bash
# Run tests without coverage
vendor/bin/phpunit --no-coverage

# Run tests with coverage (requires Xdebug)
XDEBUG_MODE=coverage vendor/bin/phpunit

# Run tests with testdox output
vendor/bin/phpunit --testdox
```

### Test Coverage

The package maintains **100% code coverage**:
- Classes: 10/10 (100%)
- Methods: 10/10 (100%)
- Lines: 71/71 (100%)

### Test Structure

Each configuration class has a corresponding test class:

```
test/
├── EasyCodingStandard/
│   └── Config/
│       └── ECSConfig/
│           ├── DefaultFileExtensionsTest.php
│           ├── DefaultIndentationTest.php
│           ├── DefaultLineEndingTest.php
│           ├── DefaultRulesTest.php
│           ├── DefaultRulesWithConfigurationTest.php
│           ├── DefaultSetsTest.php
│           └── DefaultSkipTest.php
└── Rector/
    └── Config/
        └── RectorConfig/
            ├── DefaultFileExtensionsTest.php
            ├── DefaultSetsTest.php
            └── DefaultSkipTest.php
```

---

## Project Structure

```
ctw-qa/
├── config/
│   └── phpstan/
│       └── common.neon              # Shared PHPStan configuration
├── src/
│   ├── EasyCodingStandard/
│   │   └── Config/
│   │       └── ECSConfig/
│   │           ├── DefaultFileExtensions.php
│   │           ├── DefaultIndentation.php
│   │           ├── DefaultLineEnding.php
│   │           ├── DefaultRules.php
│   │           ├── DefaultRulesWithConfiguration.php
│   │           ├── DefaultSets.php
│   │           └── DefaultSkip.php
│   └── Rector/
│       └── Config/
│           └── RectorConfig/
│               ├── DefaultFileExtensions.php
│               ├── DefaultSets.php
│               └── DefaultSkip.php
├── test/                            # Comprehensive test suite (100% coverage)
├── .gitignore
├── composer.json
├── ecs.php                          # Example ECS configuration
├── phpstan.neon                     # PHPStan configuration
├── phpunit.xml.dist                 # PHPUnit configuration
├── rector.php                       # Example Rector configuration
└── README.md
```

---

## Contributing

This is a proprietary package under active development. Contributions are currently limited to the development team.

### Development Setup

```bash
# Clone the repository
git clone <repository-url>
cd ctw-qa

# Install dependencies
composer install

# Run tests
composer test

# Run QA checks on this package itself
composer qa

# Auto-fix issues
composer qa-fix
```

---

## License

This is proprietary software. All rights reserved.

---

## FAQ

### Q: Why use this instead of configuring tools directly?

**A**: Consistency and time savings. Instead of spending hours configuring the same tools across multiple projects, you get battle-tested configurations immediately. Updates to standards are centralized.

### Q: Can I override specific rules?

**A**: Yes! Extend any configuration class and modify the returned values. See [Customizing Configurations](#customizing-configurations).

### Q: Why Yoda comparisons?

**A**: Yoda style (`value === constant`) prevents accidental assignment (`=` instead of `==`). While modern PHP makes this less critical, it's still a good safety habit.

### Q: Do I need all three tools?

**A**: Each serves a different purpose:
- **Rector**: Modernization (run periodically)
- **ECS**: Style enforcement (run always)
- **PHPStan**: Type safety (run always)

For maximum code quality, use all three.

### Q: What PHP versions are supported?

**A**: PHP 8.3+ only. This package enforces modern PHP standards and doesn't support legacy versions.

### Q: Can I use this with legacy code?

**A**: Yes, but you'll need to run Rector first to modernize the code, then fix any issues identified by PHPStan. Start with a lower PHPStan level and gradually increase it.

### Q: How do I generate a PHPStan baseline?

**A**: For legacy projects with many errors:
```bash
composer phpstan-baseline
```
This creates `phpstan-baseline.neon` with existing errors ignored. Fix them incrementally.

---

## Support

For issues, questions, or feature requests, contact the development team.

---

**Made with ❤️ for modern PHP development**
