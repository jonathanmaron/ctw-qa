<?php
declare(strict_types=1);

namespace Ctw\Qa\ComposerUnused\Configuration\Configuration;

/**
 * Packages excluded from the unused check by their exact name.
 *
 * Composer Unused decides that a package is used by matching the symbols in the
 * scanned source against the namespaces each package provides. Easy Coding
 * Standard publishes none: its classes are namespace-prefixed at build time and
 * its composer.json declares a "files" autoload only, which
 * "composer-unused debug:provided-symbols symplify/easy-coding-standard"
 * confirms by printing nothing. No file can therefore prove the dependency, and
 * a filter is the only way to keep it out of the unused list.
 */
class DefaultNamedFilters
{
    /**
     * @return array<string>
     */
    public function __invoke(): array
    {
        return [
            'symplify/easy-coding-standard',
        ];
    }
}
