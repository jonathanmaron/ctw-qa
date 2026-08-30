<?php

declare(strict_types=1);

namespace CtwTest\Qa\ComposerUnused\Configuration\Configuration;

use Ctw\Qa\ComposerUnused\Configuration\Configuration\DefaultPatternFilters;
use PHPUnit\Framework\TestCase;

final class DefaultPatternFiltersTest extends TestCase
{
    private DefaultPatternFilters $defaultPatternFilters;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultPatternFilters = new DefaultPatternFilters();
    }

    /**
     * Test that invocation returns the full expected list of patterns in source order.
     */
    public function testInvokeReturnsExpectedPatternsInSourceOrder(): void
    {
        $expected = [
            '/^phpstan\/.*/',
            '/^rector\/.*/',
        ];

        $actual = ($this->defaultPatternFilters)();

        self::assertSame($expected, $actual);
    }

    /**
     * Test that invocation never returns an empty array, since the curated pattern list always has entries.
     */
    public function testInvokeReturnsNonEmptyArray(): void
    {
        $actual = ($this->defaultPatternFilters)();

        self::assertNotEmpty($actual);
    }

    /**
     * Test that invocation returns exactly two patterns, pinning the curated pattern count.
     */
    public function testInvokeReturnsExactlyTwoPatterns(): void
    {
        $actual = ($this->defaultPatternFilters)();

        self::assertCount(2, $actual);
    }

    /**
     * Test that every returned pattern compiles, since Composer Unused passes it straight to preg_match().
     */
    public function testInvokeAllPatternsCompile(): void
    {
        $actual = ($this->defaultPatternFilters)();

        foreach ($actual as $pattern) {
            self::assertIsInt(@preg_match($pattern, 'vendor/package'));
        }
    }

    /**
     * Test that the PHPStan pattern matches PHPStan itself and its extension packages.
     */
    public function testInvokePhpstanPatternMatchesPhpstanVendor(): void
    {
        $actual = ($this->defaultPatternFilters)();

        self::assertMatchesRegularExpression($actual[0], 'phpstan/phpstan');
        self::assertMatchesRegularExpression($actual[0], 'phpstan/phpstan-phpunit');
        self::assertMatchesRegularExpression($actual[0], 'phpstan/extension-installer');
    }

    /**
     * Test that the Rector pattern matches Rector itself and its extension packages.
     */
    public function testInvokeRectorPatternMatchesRectorVendor(): void
    {
        $actual = ($this->defaultPatternFilters)();

        self::assertMatchesRegularExpression($actual[1], 'rector/rector');
        self::assertMatchesRegularExpression($actual[1], 'rector/rector-doctrine');
    }

    /**
     * Test that the patterns are anchored to the vendor, so an unrelated package is never filtered.
     */
    public function testInvokePatternsDoNotMatchUnrelatedPackages(): void
    {
        $actual = ($this->defaultPatternFilters)();

        foreach ($actual as $pattern) {
            self::assertDoesNotMatchRegularExpression($pattern, 'symplify/easy-coding-standard');
            self::assertDoesNotMatchRegularExpression($pattern, 'acme/phpstan-reporter');
            self::assertDoesNotMatchRegularExpression($pattern, 'acme/rector-rules');
        }
    }

    /**
     * Test that every returned pattern is delimited, since Composer Unused adds no delimiters of its own.
     */
    public function testInvokeAllPatternsAreDelimited(): void
    {
        $actual = ($this->defaultPatternFilters)();

        foreach ($actual as $pattern) {
            self::assertStringStartsWith('/', $pattern);
            self::assertStringEndsWith('/', $pattern);
        }
    }

    /**
     * Test that invocation returns a zero-indexed (list-style) array.
     */
    public function testInvokeReturnsIndexedArray(): void
    {
        $actual = ($this->defaultPatternFilters)();

        self::assertSame(array_values($actual), $actual);
    }

    /**
     * Test that invocation returns no duplicate patterns.
     */
    public function testInvokeReturnsUniquePatterns(): void
    {
        $actual = ($this->defaultPatternFilters)();

        self::assertSame(array_values(array_unique($actual)), $actual);
    }

    /**
     * Test that every returned pattern is a non-empty string, since Composer Unused rejects empty filters.
     */
    public function testInvokeAllValuesAreNonEmptyStrings(): void
    {
        $actual = ($this->defaultPatternFilters)();

        foreach ($actual as $value) {
            self::assertNotEmpty($value);
        }
    }

    /**
     * Test that invocation produces the same result when called more than once.
     */
    public function testInvokeIsIdempotentAcrossRepeatedCalls(): void
    {
        $firstCall  = ($this->defaultPatternFilters)();
        $secondCall = ($this->defaultPatternFilters)();

        self::assertSame($firstCall, $secondCall);
    }
}
