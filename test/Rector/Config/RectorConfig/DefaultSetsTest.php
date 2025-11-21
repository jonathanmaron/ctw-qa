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
     * Test that invocation returns expected sets
     */
    public function testInvokeReturnsExpectedSets(): void
    {
        $expected = [
            LevelSetList::UP_TO_PHP_83,
            PHPUnitSetList::PHPUNIT_100,
            SetList::CODE_QUALITY,
            SetList::CODING_STYLE,
            SetList::DEAD_CODE,
            SetList::NAMING,
        ];

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
     * Test that invocation returns exactly six sets
     */
    public function testInvokeReturnsExactlySixSets(): void
    {
        $actual = ($this->defaultSets)();

        self::assertCount(6, $actual);
    }

    /**
     * Test that invocation includes UP_TO_PHP_83 level set
     */
    public function testInvokeIncludesUpToPhp83LevelSet(): void
    {
        $actual = ($this->defaultSets)();

        self::assertContains(LevelSetList::UP_TO_PHP_83, $actual);
    }

    /**
     * Test that invocation includes PHPUNIT_100 set
     */
    public function testInvokeIncludesPhpunit100Set(): void
    {
        $actual = ($this->defaultSets)();

        self::assertContains(PHPUnitSetList::PHPUNIT_100, $actual);
    }

    /**
     * Test that invocation includes CODE_QUALITY set
     */
    public function testInvokeIncludesCodeQualitySet(): void
    {
        $actual = ($this->defaultSets)();

        self::assertContains(SetList::CODE_QUALITY, $actual);
    }

    /**
     * Test that invocation includes CODING_STYLE set
     */
    public function testInvokeIncludesCodingStyleSet(): void
    {
        $actual = ($this->defaultSets)();

        self::assertContains(SetList::CODING_STYLE, $actual);
    }

    /**
     * Test that invocation includes DEAD_CODE set
     */
    public function testInvokeIncludesDeadCodeSet(): void
    {
        $actual = ($this->defaultSets)();

        self::assertContains(SetList::DEAD_CODE, $actual);
    }

    /**
     * Test that invocation includes NAMING set
     */
    public function testInvokeIncludesNamingSet(): void
    {
        $actual = ($this->defaultSets)();

        self::assertContains(SetList::NAMING, $actual);
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
     * Test that all values contain Set path
     */
    public function testInvokeAllValuesContainSetPath(): void
    {
        $actual = ($this->defaultSets)();

        foreach ($actual as $value) {
            self::assertIsString($value);
            self::assertStringContainsString('Set/', $value);
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
