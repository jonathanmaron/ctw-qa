<?php
declare(strict_types=1);

use ComposerUnused\ComposerUnused\Configuration\Configuration;
use ComposerUnused\ComposerUnused\Configuration\NamedFilter;
use ComposerUnused\ComposerUnused\Configuration\PatternFilter;
use Ctw\Qa\ComposerUnused\Configuration\Configuration\DefaultNamedFilters;
use Ctw\Qa\ComposerUnused\Configuration\Configuration\DefaultPatternFilters;

/**
 * The filters below are this package's own classes, so this file cannot rely
 * on whichever autoloader happens to be in scope when Composer Unused reads
 * it. CI installs the tool into a throwaway project outside this tree, so that
 * resolving it cannot disturb the resolution being checked — and that process
 * knows nothing of the Ctw\Qa namespace.
 *
 * require_once is a no-op when the tool runs from this package's own vendor,
 * and is what makes the file work when it does not. Composer appends its
 * autoloader rather than prepending it, so the tool's own classes keep
 * priority.
 */
require_once __DIR__ . '/vendor/autoload.php';

return static function (Configuration $configuration): Configuration {
    $namedFilters   = new DefaultNamedFilters();
    $patternFilters = new DefaultPatternFilters();

    foreach ($namedFilters() as $namedFilter) {
        $configuration->addNamedFilter(NamedFilter::fromString($namedFilter));
    }

    foreach ($patternFilters() as $patternFilter) {
        $configuration->addPatternFilter(PatternFilter::fromString($patternFilter));
    }

    /**
     * Unlike the filtered tools, Composer Unused publishes its own namespace and
     * this file references it, so adding this file to the scan proves the
     * dependency rather than filtering it away. The key is the root package's
     * own name, which is what Composer Unused looks the additional files up by.
     */
    $configuration->setAdditionalFilesFor('ctw/ctw-qa', [__FILE__]);

    return $configuration;
};
