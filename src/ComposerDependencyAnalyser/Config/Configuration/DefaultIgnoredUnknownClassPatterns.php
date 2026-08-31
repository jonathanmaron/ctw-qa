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
 * The two namespaces share one pattern, and that is deliberate. Easy Coding
 * Standard's "bootstrap.php" is autoloaded eagerly but registers a *lazy*
 * autoloader: it acts only on a class named "Symplify\..." or "ECSPrefix...",
 * and the first such class requested makes it require the nested
 * "vendor/autoload.php". That registers the whole nested tree, after which
 * "PhpCsFixer\..." resolves and is attributed to symplify/easy-coding-standard
 * rather than reported as unknown. "PHP_CodeSniffer\..." stays unknown either
 * way, being prefixed in that tree.
 *
 * So whether the fixers are unknown depends on whether a "Symplify\" symbol was
 * resolved before them, which depends in turn on the order the analyser happens
 * to scan files in — and that differs between one filesystem and another. As
 * two patterns, the fixer one goes unmatched wherever the sniffs are scanned
 * last, and an ignore that never applies is itself reported as an error. As one
 * pattern, the sniffs alone are enough to match it, so the ignore applies in
 * either order.
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
            '/^(PHP_CodeSniffer|PhpCsFixer)\\\\/',
        ];
    }
}
