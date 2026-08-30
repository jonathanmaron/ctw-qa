<?php

declare(strict_types=1);

namespace CtwTest\Qa\ComposerUnused\Configuration\Configuration;

use Ctw\Qa\ComposerUnused\Configuration\Configuration\DefaultNamedFilters;
use PHPUnit\Framework\TestCase;

final class DefaultNamedFiltersTest extends TestCase
{
    private DefaultNamedFilters $defaultNamedFilters;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultNamedFilters = new DefaultNamedFilters();
    }

    /**
     * Test that invocation returns the full expected list of package names in source order.
     */
    public function testInvokeReturnsExpectedPackagesInSourceOrder(): void
    {
        $expected = [
            'symplify/easy-coding-standard',
        ];

        $actual = ($this->defaultNamedFilters)();

        self::assertSame($expected, $actual);
    }

    /**
     * Test that invocation never returns an empty array, since the curated filter list always has entries.
     */
    public function testInvokeReturnsNonEmptyArray(): void
    {
        $actual = ($this->defaultNamedFilters)();

        self::assertNotEmpty($actual);
    }

    /**
     * Test that invocation returns exactly one package name, pinning the curated filter count.
     */
    public function testInvokeReturnsExactlyOnePackage(): void
    {
        $actual = ($this->defaultNamedFilters)();

        self::assertCount(1, $actual);
    }

    /**
     * Test that Composer Unused is absent, since it publishes a namespace and is proven used instead.
     */
    public function testInvokeExcludesComposerUnusedItself(): void
    {
        $actual = ($this->defaultNamedFilters)();

        self::assertNotContains('icanhazstring/composer-unused', $actual);
    }

    /**
     * Test that invocation includes Easy Coding Standard, which ships a namespace-prefixed build.
     */
    public function testInvokeIncludesEasyCodingStandard(): void
    {
        $actual = ($this->defaultNamedFilters)();

        self::assertContains('symplify/easy-coding-standard', $actual);
    }

    /**
     * Test that every returned value is a vendor/package name, as Composer Unused matches on the exact name.
     */
    public function testInvokeAllValuesAreVendorPackageNames(): void
    {
        $actual = ($this->defaultNamedFilters)();

        foreach ($actual as $value) {
            self::assertMatchesRegularExpression('#^[a-z0-9-]+/[a-z0-9._-]+$#', $value);
        }
    }

    /**
     * Test that no returned value carries regular expression delimiters, which belong to pattern filters only.
     */
    public function testInvokeValuesCarryNoRegularExpressionDelimiters(): void
    {
        $actual = ($this->defaultNamedFilters)();

        foreach ($actual as $value) {
            self::assertStringStartsNotWith('/', $value);
        }
    }

    /**
     * Test that invocation returns a zero-indexed (list-style) array.
     */
    public function testInvokeReturnsIndexedArray(): void
    {
        $actual = ($this->defaultNamedFilters)();

        self::assertSame(array_values($actual), $actual);
    }

    /**
     * Test that invocation returns no duplicate package names.
     */
    public function testInvokeReturnsUniquePackages(): void
    {
        $actual = ($this->defaultNamedFilters)();

        self::assertSame(array_values(array_unique($actual)), $actual);
    }

    /**
     * Test that every returned package name is a non-empty string, since Composer Unused rejects empty filters.
     */
    public function testInvokeAllValuesAreNonEmptyStrings(): void
    {
        $actual = ($this->defaultNamedFilters)();

        foreach ($actual as $value) {
            self::assertNotEmpty($value);
        }
    }

    /**
     * Test that invocation produces the same result when called more than once.
     */
    public function testInvokeIsIdempotentAcrossRepeatedCalls(): void
    {
        $firstCall  = ($this->defaultNamedFilters)();
        $secondCall = ($this->defaultNamedFilters)();

        self::assertSame($firstCall, $secondCall);
    }
}
