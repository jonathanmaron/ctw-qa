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
     * Test that invocation returns expected sets
     */
    public function testInvokeReturnsExpectedSets(): void
    {
        $expected = [SetList::CLEAN_CODE, SetList::COMMON, SetList::PSR_12, SetList::STRICT, SetList::SYMPLIFY];

        $actual = ($this->defaultSets)();

        self::assertSame($expected, $actual);
    }

    /**
     * Test that invocation returns non-empty array
     */
    public function testInvokeReturnsNonEmptyArray(): void
    {
        $actual = ($this->defaultSets)();

        self::assertNotEmpty($actual);
    }

    /**
     * Test that invocation returns exactly five sets
     */
    public function testInvokeReturnsExactlyFiveSets(): void
    {
        $actual = ($this->defaultSets)();

        self::assertCount(5, $actual);
    }

    /**
     * Test that invocation includes CLEAN_CODE set
     */
    public function testInvokeIncludesCleanCodeSet(): void
    {
        $actual = ($this->defaultSets)();

        self::assertContains(SetList::CLEAN_CODE, $actual);
    }

    /**
     * Test that invocation includes COMMON set
     */
    public function testInvokeIncludesCommonSet(): void
    {
        $actual = ($this->defaultSets)();

        self::assertContains(SetList::COMMON, $actual);
    }

    /**
     * Test that invocation includes PSR_12 set
     */
    public function testInvokeIncludesPsr12Set(): void
    {
        $actual = ($this->defaultSets)();

        self::assertContains(SetList::PSR_12, $actual);
    }

    /**
     * Test that invocation includes STRICT set
     */
    public function testInvokeIncludesStrictSet(): void
    {
        $actual = ($this->defaultSets)();

        self::assertContains(SetList::STRICT, $actual);
    }

    /**
     * Test that invocation includes SYMPLIFY set
     */
    public function testInvokeIncludesSymplifySet(): void
    {
        $actual = ($this->defaultSets)();

        self::assertContains(SetList::SYMPLIFY, $actual);
    }

    /**
     * Test that all values are strings
     */
    public function testInvokeAllValuesAreStrings(): void
    {
        $actual = ($this->defaultSets)();

        foreach ($actual as $value) {
            self::assertIsString($value);
        }
    }

    /**
     * Test that all values contain set path
     */
    public function testInvokeAllValuesContainSetPath(): void
    {
        $actual = ($this->defaultSets)();

        foreach ($actual as $value) {
            self::assertIsString($value);
            self::assertStringContainsStringIgnoringCase('set/', $value);
        }
    }

    /**
     * Test that invocation returns indexed array
     */
    public function testInvokeReturnsIndexedArray(): void
    {
        $actual = ($this->defaultSets)();

        self::assertSame(array_values($actual), $actual);
    }

    /**
     * Test that invocation is idempotent
     */
    public function testInvokeIsIdempotent(): void
    {
        $firstCall = ($this->defaultSets)();
        $secondCall = ($this->defaultSets)();

        self::assertSame($firstCall, $secondCall);
    }
}
