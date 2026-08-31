<?php
declare(strict_types=1);

namespace Ctw\Qa\ComposerDependencyAnalyser\Config\Configuration;

use ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;

/**
 * Errors excluded from the analysis by exact package name.
 *
 * Composer Dependency Analyser decides that a package is used by resolving the
 * symbols in the scanned source back to the package that autoloads them. The
 * PHPStan packages below are never resolved that way: PHPStan itself ships a
 * namespace-prefixed build, and its extensions are wired up through
 * "phpstan.neon" rather than referenced in code. The extension installer is a
 * Composer plugin and is referenced from nowhere at all.
 *
 * Only UNUSED_DEPENDENCY is excluded, so a package that turns into a genuine
 * error of another kind is still reported. UNKNOWN_CLASS and UNKNOWN_FUNCTION
 * cannot be excluded per package at all: the analyser rejects them, because a
 * symbol it cannot autoload has no package to attribute the error to. Those
 * belong in DefaultIgnoredUnknownClassPatterns instead.
 *
 * Unmatched exclusions are themselves reported, so extend this list rather than
 * inherit it wholesale: a project that installs no PHPStan extension is told
 * that the entry for it never fired.
 *
 * The keys are exact package names. The analyser has no pattern equivalent for
 * them, so every PHPStan extension added to a project is named here.
 */
class DefaultIgnoredPackageErrors
{
    /**
     * @return array<string, list<ErrorType::*>>
     */
    public function __invoke(): array
    {
        return [
            'phpstan/extension-installer'  => [ErrorType::UNUSED_DEPENDENCY],
            'phpstan/phpstan'              => [ErrorType::UNUSED_DEPENDENCY],
            'phpstan/phpstan-phpunit'      => [ErrorType::UNUSED_DEPENDENCY],
            'phpstan/phpstan-strict-rules' => [ErrorType::UNUSED_DEPENDENCY],
        ];
    }
}
