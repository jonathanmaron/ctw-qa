<?php
declare(strict_types=1);

use Ctw\Qa\ComposerDependencyAnalyser\Config\Configuration\DefaultFileExtensions;
use Ctw\Qa\ComposerDependencyAnalyser\Config\Configuration\DefaultIgnoredPackageErrors;
use Ctw\Qa\ComposerDependencyAnalyser\Config\Configuration\DefaultIgnoredUnknownClassPatterns;
use ShipMonk\ComposerDependencyAnalyser\Config\Configuration;

/**
 * The filters below are this package's own classes, and unlike its sibling
 * "composer-unused.php" this file needs no require of the autoloader to reach
 * them: the analyser loads the vendor directory belonging to the composer.json
 * it is analysing before it reads this file. That holds even when CI installs
 * the tool into a throwaway project outside this tree, so that resolving it
 * cannot disturb the resolution being checked.
 */
$fileExtensions       = new DefaultFileExtensions();
$packageErrors        = new DefaultIgnoredPackageErrors();
$unknownClassPatterns = new DefaultIgnoredUnknownClassPatterns();

$configuration = new Configuration();

$configuration->setFileExtensions($fileExtensions());

foreach ($packageErrors() as $packageName => $errorTypes) {
    $configuration->ignoreErrorsOnPackage($packageName, $errorTypes);
}

foreach ($unknownClassPatterns() as $unknownClassPattern) {
    $configuration->ignoreUnknownClassesRegex($unknownClassPattern);
}

/**
 * The analyser scans the autoload paths of composer.json on its own, which
 * covers "src" and "test" but not the root of the package. The tools
 * configured from these files are named nowhere else, so scanning the files
 * proves those dependencies rather than excluding them.
 *
 * They are scanned as production paths, since the tools they configure are
 * production requirements of this package rather than development ones.
 */
$configuration->addPathsToScan(
    [
        sprintf('%s/composer-dependency-analyser.php', __DIR__),
        sprintf('%s/composer-unused.php', __DIR__),
        sprintf('%s/ecs.php', __DIR__),
        sprintf('%s/rector.php', __DIR__),
    ],
    false
);

return $configuration;
