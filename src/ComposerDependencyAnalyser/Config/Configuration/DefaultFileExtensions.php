<?php
declare(strict_types=1);

namespace Ctw\Qa\ComposerDependencyAnalyser\Config\Configuration;

/**
 * File extensions the analyser reads when it scans a path.
 *
 * Composer Dependency Analyser defaults to "php" alone. Templates are PHP too,
 * and a class referenced only from a ".phtml" file is a real usage that the
 * default would miss, reporting the package it belongs to as unused.
 *
 * The list carries no leading dot, which is what setFileExtensions() expects.
 */
class DefaultFileExtensions
{
    /**
     * @return array<string>
     */
    public function __invoke(): array
    {
        return ['php', 'phtml'];
    }
}
