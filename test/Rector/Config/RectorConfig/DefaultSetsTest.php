<?php

declare(strict_types=1);

namespace CtwTest\Qa\Rector\Config\RectorConfig;

use Ctw\Qa\Rector\Config\RectorConfig\DefaultSets;
use PHPUnit\Framework\TestCase;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

final class DefaultSetsTest extends TestCase
{
    private DefaultSets $defaultSets;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultSets = new DefaultSets();
    }

    /**
     * Test that invocation returns the full expected list of Rector set paths in source order.
     */
    public function testInvokeReturnsExpectedSetsInSourceOrder(): void
    {
        $expected = [
            LevelSetList::UP_TO_PHP_85,
            PHPUnitSetList::PHPUNIT_120,
            SetList::CODE_QUALITY,
            SetList::CODING_STYLE,
            SetList::DEAD_CODE,
            SetList::NAMING,
        ];

        $actual = ($this->defaultSets)();

        self::assertSame($expected, $actual);
    }

    /**
     * Test that invocation never returns an empty array, since Rector requires at least one set.
     */
    public function testInvokeReturnsNonEmptyArray(): void
    {
        $actual = ($this->defaultSets)();

        self::assertNotEmpty($actual);
    }

    /**
     * Test that invocation returns exactly six sets, pinning the curated set count.
     */
    public function testInvokeReturnsExactlySixSets(): void
    {
        $actual = ($this->defaultSets)();

        self::assertCount(6, $actual);
    }

    /**
     * Test that invocation includes the UP_TO_PHP_85 level set.
     */
    public function testInvokeIncludesUpToPhp85LevelSet(): void
    {
        $actual = ($this->defaultSets)();

        self::assertContains(LevelSetList::UP_TO_PHP_85, $actual);
    }

    /**
     * Test that invocation includes the PHPUNIT_120 set.
     */
    public function testInvokeIncludesPhpunit120Set(): void
    {
        $actual = ($this->defaultSets)();

        self::assertContains(PHPUnitSetList::PHPUNIT_120, $actual);
    }

    /**
     * Test that invocation includes the CODE_QUALITY set.
     */
    public function testInvokeIncludesCodeQualitySet(): void
    {
        $actual = ($this->defaultSets)();

        self::assertContains(SetList::CODE_QUALITY, $actual);
    }

    /**
     * Test that invocation includes the CODING_STYLE set.
     */
    public function testInvokeIncludesCodingStyleSet(): void
    {
        $actual = ($this->defaultSets)();

        self::assertContains(SetList::CODING_STYLE, $actual);
    }

    /**
     * Test that invocation includes the DEAD_CODE set.
     */
    public function testInvokeIncludesDeadCodeSet(): void
    {
        $actual = ($this->defaultSets)();

        self::assertContains(SetList::DEAD_CODE, $actual);
    }

    /**
     * Test that invocation includes the NAMING set.
     */
    public function testInvokeIncludesNamingSet(): void
    {
        $actual = ($this->defaultSets)();

        self::assertContains(SetList::NAMING, $actual);
    }

    /**
     * Test that every returned value looks like a Rector set file path (contains 'Set/').
     */
    public function testInvokeAllValuesContainSetPath(): void
    {
        $actual = ($this->defaultSets)();

        foreach ($actual as $value) {
            self::assertStringContainsString('Set/', $value);
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
