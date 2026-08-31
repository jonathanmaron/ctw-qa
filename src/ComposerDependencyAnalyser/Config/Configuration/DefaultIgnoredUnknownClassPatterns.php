<?php
declare(strict_types=1);

namespace Ctw\Qa\ComposerDependencyAnalyser\Config\Configuration;

/**
 * Unknown classes excluded from the analysis by a regular expression.
 *
 * Easy Coding Standard names its fixers and sniffs with the classes of
 * friendsofphp/php-cs-fixer and squizlabs/php_codesniffer, but requires
 * neither: it bundles both in a nested vendor tree of its own, behind an
 * autoloader that is only registered once the tool boots. A configuration class
 * that names such a fixer therefore references a class that resolves at runtime
 * and yet is unknown to the analyser.
 *
 * Whole namespaces are excluded rather than individual classes because the set
 * is open-ended: every fixer added to a rule or skip list would otherwise have
 * to be named here as well, and ordinary work would fail the check until
 * somebody remembered to.
 *
 * Each pattern is passed to preg_match() and therefore carries its delimiters.
 * The backslash separating the namespace is doubled for PHP and escaped again
 * for the pattern.
 */
class DefaultIgnoredUnknownClassPatterns
{
    /**
     * @return array<string>
     */
    public function __invoke(): array
    {
        return [
            '/^PHP_CodeSniffer\\\\/',
            '/^PhpCsFixer\\\\/',
        ];
    }
}
