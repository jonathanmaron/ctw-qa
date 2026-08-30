<?php
declare(strict_types=1);

namespace Ctw\Qa\ComposerUnused\Configuration\Configuration;

/**
 * Packages excluded from the unused check by their exact name.
 *
 * Composer Unused decides that a package is used by matching the symbols in the
 * scanned source against the namespaces each package provides. A QA tool never
 * matches: it is either shipped as a namespace-prefixed build, registered as a
 * Composer plugin, or run as a console binary, so no project symbol maps back
 * to it. Without these filters every such tool is reported as unused.
 */
class DefaultNamedFilters
{
    /**
     * @return array<string>
     */
    public function __invoke(): array
    {
        return [
            'icanhazstring/composer-unused',
            'symplify/easy-coding-standard',
        ];
    }
}
