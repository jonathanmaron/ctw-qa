<?php

declare(strict_types=1);

namespace CtwTest\Qa\EasyCodingStandard\Config\ECSConfig;

use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultSets;
use PHPUnit\Framework\TestCase;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

final class DefaultSetsTest extends TestCase
{
    private DefaultSets $defaultSets;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultSets = new DefaultSets();
    }

    /**
     * Test that invocation returns the full expected list of ECS set paths in source order.
     */
    public function testInvokeReturnsExpectedSetsInSourceOrder(): void
    {
        $expected = [SetList::CLEAN_CODE, SetList::COMMON, SetList::PSR_12, SetList::SYMPLIFY];

        $actual = ($this->defaultSets)();

        self::assertSame($expected, $actual);
    }

    /**
     * Test that invocation never returns an empty array, since ECS requires at least one set.
     */
    public function testInvokeReturnsNonEmptyArray(): void
    {
        $actual = ($this->defaultSets)();

        self::assertNotEmpty($actual);
    }

    /**
     * Test that invocation returns exactly four sets after the STRICT deprecation removal.
     */
    public function testInvokeReturnsExactlyFourSets(): void
    {
        $actual = ($this->defaultSets)();

        self::assertCount(4, $actual);
    }

    /**
     * Test that invocation includes the CLEAN_CODE set.
     */
    public function testInvokeIncludesCleanCodeSet(): void
    {
        $actual = ($this->defaultSets)();

        self::assertContains(SetList::CLEAN_CODE, $actual);
    }

    /**
     * Test that invocation includes the COMMON set.
     */
    public function testInvokeIncludesCommonSet(): void
    {
        $actual = ($this->defaultSets)();

        self::assertContains(SetList::COMMON, $actual);
    }

    /**
     * Test that invocation includes the PSR_12 set.
     */
    public function testInvokeIncludesPsr12Set(): void
    {
        $actual = ($this->defaultSets)();

        self::assertContains(SetList::PSR_12, $actual);
    }

    /**
     * Test that invocation excludes the STRICT set, since ECS 13.1.x throws on load when it is included.
     */
    public function testInvokeExcludesStrictSet(): void
    {
        $actual = ($this->defaultSets)();

        self::assertNotContains(SetList::STRICT, $actual);
    }

    /**
     * Test that invocation includes the SYMPLIFY set.
     */
    public function testInvokeIncludesSymplifySet(): void
    {
        $actual = ($this->defaultSets)();

        self::assertContains(SetList::SYMPLIFY, $actual);
    }

    /**
     * Test that every returned value looks like an ECS set file path (contains 'set/').
     */
    public function testInvokeAllValuesContainSetPath(): void
    {
        $actual = ($this->defaultSets)();

        foreach ($actual as $value) {
            self::assertStringContainsStringIgnoringCase('set/', $value);
        }
    }

    /**
     * Test that invocation returns a zero-indexed (list-style) array.
     */
    public function testInvokeReturnsIndexedArray(): void
    {
        $actual = ($this->defaultSets)();

        self::assertSame(array_values($actual), $actual);
    }

    /**
     * Test that invocation returns no duplicate set paths.
     */
    public function testInvokeReturnsUniqueSets(): void
    {
        $actual = ($this->defaultSets)();

        self::assertSame(array_values(array_unique($actual)), $actual);
    }

    /**
     * Test that every returned set path is a non-empty string.
     */
    public function testInvokeAllValuesAreNonEmptyStrings(): void
    {
        $actual = ($this->defaultSets)();

        foreach ($actual as $value) {
            self::assertNotEmpty($value);
        }
    }

    /**
     * Test that invocation produces the same result when called more than once.
     */
    public function testInvokeIsIdempotentAcrossRepeatedCalls(): void
    {
        $firstCall  = ($this->defaultSets)();
        $secondCall = ($this->defaultSets)();

        self::assertSame($firstCall, $secondCall);
    }
}
