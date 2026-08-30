<?php
declare(strict_types=1);

use ComposerUnused\ComposerUnused\Configuration\Configuration;
use ComposerUnused\ComposerUnused\Configuration\NamedFilter;
use ComposerUnused\ComposerUnused\Configuration\PatternFilter;
use Ctw\Qa\ComposerUnused\Configuration\Configuration\DefaultNamedFilters;
use Ctw\Qa\ComposerUnused\Configuration\Configuration\DefaultPatternFilters;

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
