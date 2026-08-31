<?php

declare(strict_types=1);

namespace CtwTest\Qa\ComposerDependencyAnalyser\Config\Configuration;

use Ctw\Qa\ComposerDependencyAnalyser\Config\Configuration\DefaultIgnoredPackageErrors;
use PHPUnit\Framework\TestCase;
use ShipMonk\ComposerDependencyAnalyser\Config\ErrorType;

final class DefaultIgnoredPackageErrorsTest extends TestCase
{
    private DefaultIgnoredPackageErrors $defaultIgnoredPackageErrors;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultIgnoredPackageErrors = new DefaultIgnoredPackageErrors();
    }

    /**
     * Test that invocation returns the full expected map of packages in source order.
     */
    public function testInvokeReturnsExpectedPackagesInSourceOrder(): void
    {
        $expected = [
            'phpstan/extension-installer'  => [ErrorType::UNUSED_DEPENDENCY],
            'phpstan/phpstan'              => [ErrorType::UNUSED_DEPENDENCY],
            'phpstan/phpstan-phpunit'      => [ErrorType::UNUSED_DEPENDENCY],
            'phpstan/phpstan-strict-rules' => [ErrorType::UNUSED_DEPENDENCY],
        ];

        $actual = ($this->defaultIgnoredPackageErrors)();

        self::assertSame($expected, $actual);
    }

    /**
     * Test that invocation never returns an empty array, since the curated list always has entries.
     */
    public function testInvokeReturnsNonEmptyArray(): void
    {
        $actual = ($this->defaultIgnoredPackageErrors)();

        self::assertNotEmpty($actual);
    }

    /**
     * Test that invocation returns exactly four packages, pinning the curated package count.
     */
    public function testInvokeReturnsExactlyFourPackages(): void
    {
        $actual = ($this->defaultIgnoredPackageErrors)();

        self::assertCount(4, $actual);
    }

    /**
     * Test that PHPStan and each of its extensions is present, none being provable by a symbol scan.
     */
    public function testInvokeIncludesPhpstanAndItsExtensions(): void
    {
        $actual = ($this->defaultIgnoredPackageErrors)();

        self::assertArrayHasKey('phpstan/extension-installer', $actual);
        self::assertArrayHasKey('phpstan/phpstan', $actual);
        self::assertArrayHasKey('phpstan/phpstan-phpunit', $actual);
        self::assertArrayHasKey('phpstan/phpstan-strict-rules', $actual);
    }

    /**
     * Test that the tools proven used by a scanned file are absent, an exclusion for them being unmatched.
     */
    public function testInvokeExcludesTheToolsProvenUsedByAScannedFile(): void
    {
        $actual = ($this->defaultIgnoredPackageErrors)();

        self::assertArrayNotHasKey('rector/rector', $actual);
        self::assertArrayNotHasKey('shipmonk/composer-dependency-analyser', $actual);
        self::assertArrayNotHasKey('symplify/easy-coding-standard', $actual);
    }

    /**
     * Test that every key is a vendor/package name, since the analyser validates it against Composer's schema.
     */
    public function testInvokeAllKeysAreVendorPackageNames(): void
    {
        $actual = ($this->defaultIgnoredPackageErrors)();

        foreach (array_keys($actual) as $packageName) {
            self::assertMatchesRegularExpression('#^[a-z0-9-]+/[a-z0-9._-]+$#', $packageName);
        }
    }

    /**
     * Test that only the unused dependency error is excluded, leaving every other kind reported.
     */
    public function testInvokeExcludesUnusedDependencyErrorsOnly(): void
    {
        $actual = ($this->defaultIgnoredPackageErrors)();

        foreach ($actual as $errorTypes) {
            self::assertSame([ErrorType::UNUSED_DEPENDENCY], $errorTypes);
        }
    }

    /**
     * Test that no unknown symbol error is excluded, the analyser rejecting those on a package.
     */
    public function testInvokeExcludesNoUnknownSymbolErrors(): void
    {
        $actual = ($this->defaultIgnoredPackageErrors)();

        foreach ($actual as $errorTypes) {
            self::assertNotContains(ErrorType::UNKNOWN_CLASS, $errorTypes);
            self::assertNotContains(ErrorType::UNKNOWN_FUNCTION, $errorTypes);
        }
    }

    /**
     * Test that every error type is one the analyser defines, an unknown string matching nothing.
     */
    public function testInvokeAllErrorTypesAreDefinedByTheAnalyser(): void
    {
        $known = [
            ErrorType::DEV_DEPENDENCY_IN_PROD,
            ErrorType::PROD_DEPENDENCY_ONLY_IN_DEV,
            ErrorType::SHADOW_DEPENDENCY,
            ErrorType::UNKNOWN_CLASS,
            ErrorType::UNKNOWN_FUNCTION,
            ErrorType::UNUSED_DEPENDENCY,
        ];

        $actual = ($this->defaultIgnoredPackageErrors)();

        foreach ($actual as $errorTypes) {
            foreach ($errorTypes as $errorType) {
                self::assertContains($errorType, $known);
            }
        }
    }

    /**
     * Test that no value is empty, an exclusion of nothing being a silent no-op.
     */
    public function testInvokeAllValuesAreNonEmpty(): void
    {
        $actual = ($this->defaultIgnoredPackageErrors)();

        foreach ($actual as $errorTypes) {
            self::assertNotEmpty($errorTypes);
        }
    }

    /**
     * Test that no value repeats an error type, which the analyser would merge into a duplicate.
     */
    public function testInvokeAllValuesAreUnique(): void
    {
        $actual = ($this->defaultIgnoredPackageErrors)();

        foreach ($actual as $errorTypes) {
            self::assertSame(array_values(array_unique($errorTypes)), $errorTypes);
        }
    }

    /**
     * Test that invocation produces the same result when called more than once.
     */
    public function testInvokeIsIdempotentAcrossRepeatedCalls(): void
    {
        $firstCall  = ($this->defaultIgnoredPackageErrors)();
        $secondCall = ($this->defaultIgnoredPackageErrors)();

        self::assertSame($firstCall, $secondCall);
    }
}
