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

    return $configuration;
};
