<?php

declare(strict_types=1);

namespace CtwTest\Qa\Rector\Config\RectorConfig;

use Ctw\Qa\Rector\Config\RectorConfig\DefaultSkip;
use PHPUnit\Framework\TestCase;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;

final class DefaultSkipTest extends TestCase
{
    private DefaultSkip $defaultSkip;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultSkip = new DefaultSkip();
    }

    /**
     * Test that invocation never returns an empty array, since the curated skip list always has entries.
     */
    public function testInvokeReturnsNonEmptyArray(): void
    {
        $actual = ($this->defaultSkip)();

        self::assertNotEmpty($actual);
    }

    /**
     * Test that invocation includes all common project directory glob patterns.
     */
    public function testInvokeIncludesCommonProjectDirectories(): void
    {
        $actual = ($this->defaultSkip)();

        self::assertContains('*/build/*', $actual);
        self::assertContains('*/compiled/*', $actual);
        self::assertContains('*/doc/*', $actual);
        self::assertContains('*/docs/*', $actual);
        self::assertContains('*/node_modules/*', $actual);
        self::assertContains('*/vendor/*', $actual);
    }

    /**
     * Test that invocation skips no Naming rule: Rector 2.8.0 deprecated the three it skipped, and Rector 2.9 removed the
     * naming set.
     */
    public function testInvokeSkipsNoNamingRules(): void
    {
        $actual = ($this->defaultSkip)();
        $naming = array_filter([...array_keys($actual), ...$actual], static fn(mixed $value): bool => is_string($value) && str_starts_with($value, 'Rector\\Naming\\'));

        self::assertSame([], $naming);
    }

    /**
     * Test that invocation no longer skips NewlineAfterStatementRector: Rector 2.9 deprecated it and dropped it from the
     * coding style set, so skipping it only raises a warning.
     */
    public function testInvokeNoLongerSkipsNewlineAfterStatementRector(): void
    {
        $actual = ($this->defaultSkip)();

        self::assertArrayNotHasKey(NewlineAfterStatementRector::class, $actual);
        self::assertNotContains(NewlineAfterStatementRector::class, $actual);
    }

    /**
     * Test that invocation produces the same result when called more than once.
     */
    public function testInvokeIsIdempotentAcrossRepeatedCalls(): void
    {
        $firstCall  = ($this->defaultSkip)();
        $secondCall = ($this->defaultSkip)();

        self::assertSame($firstCall, $secondCall);
    }

    /**
     * Test that invocation returns exactly the curated 6 skip entries (the project directories).
     */
    public function testInvokeReturnsSixSkipEntries(): void
    {
        $actual = ($this->defaultSkip)();

        self::assertCount(6, $actual);
    }

    /**
     * Test that every string value in the returned array is non-empty.
     */
    public function testInvokeStringValuesAreNonEmpty(): void
    {
        $actual = ($this->defaultSkip)();

        foreach ($actual as $value) {
            if (is_string($value)) {
                self::assertNotEmpty($value);
            }
        }
    }

    /**
     * Test that all six project directory patterns use the leading and trailing wildcard format.
     */
    public function testInvokeProjectDirectoryPatternsUseWildcardFormat(): void
    {
        $actual             = ($this->defaultSkip)();
        $projectDirectories = array_filter($actual, static fn(mixed $value): bool => is_string($value) && str_starts_with($value, '*/') && str_ends_with($value, '/*'));

        self::assertCount(6, $projectDirectories);
    }

    /**
     * Test that the indexed (numeric-key) string values contain no duplicates.
     */
    public function testInvokeIndexedStringValuesAreUnique(): void
    {
        $actual = ($this->defaultSkip)();

        $indexedValues = [];
        foreach ($actual as $key => $value) {
            if (is_int($key) && is_string($value)) {
                $indexedValues[] = $value;
            }
        }

        self::assertSame(array_values(array_unique($indexedValues)), $indexedValues);
    }
}
