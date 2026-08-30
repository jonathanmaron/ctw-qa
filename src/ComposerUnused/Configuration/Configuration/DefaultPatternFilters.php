<?php
declare(strict_types=1);

namespace Ctw\Qa\ComposerUnused\Configuration\Configuration;

/**
 * Packages excluded from the unused check by a regular expression on their name.
 *
 * Whole vendors are filtered here, rather than the individual packages of
 * DefaultNamedFilters, because PHPStan and Rector are extended by installing
 * further packages from the same vendor. Those extensions are wired up through
 * "phpstan.neon" and Rector sets instead of through a class reference, so each
 * one added to a project would otherwise be reported as unused.
 *
 * Each pattern is passed to preg_match() and therefore carries its delimiters.
 */
class DefaultPatternFilters
{
    /**
     * @return array<string>
     */
    public function __invoke(): array
    {
        return [
            '/^phpstan\/.*/',
            '/^rector\/.*/',
        ];
    }
}
