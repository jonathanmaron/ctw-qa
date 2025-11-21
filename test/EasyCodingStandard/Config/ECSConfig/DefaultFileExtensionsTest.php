<?php

declare(strict_types=1);

namespace CtwTest\Qa\EasyCodingStandard\Config\ECSConfig;

use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultFileExtensions;
use PHPUnit\Framework\TestCase;

final class DefaultFileExtensionsTest extends TestCase
{
    private DefaultFileExtensions $defaultFileExtensions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultFileExtensions = new DefaultFileExtensions();
    }

    /**
     * Test that invocation returns expected file extensions
     */
    public function testInvokeReturnsExpectedExtensions(): void
    {
        $expected = ['php', 'phtml'];

        $actual = ($this->defaultFileExtensions)();

        self::assertSame($expected, $actual);
    }

    /**
     * Test that invocation returns non-empty array
     */
    public function testInvokeReturnsNonEmptyArray(): void
    {
        $actual = ($this->defaultFileExtensions)();

        self::assertNotEmpty($actual);
    }

    /**
     * Test that invocation returns exactly two extensions
     */
    public function testInvokeReturnsExactlyTwoExtensions(): void
    {
        $actual = ($this->defaultFileExtensions)();

        self::assertCount(2, $actual);
    }

    /**
     * Test that invocation includes php extension
     */
    public function testInvokeIncludesPhpExtension(): void
    {
        $actual = ($this->defaultFileExtensions)();

        self::assertContains('php', $actual);
    }

    /**
     * Test that invocation includes phtml extension
     */
    public function testInvokeIncludesPhtmlExtension(): void
    {
        $actual = ($this->defaultFileExtensions)();

        self::assertContains('phtml', $actual);
    }

    /**
     * Test that invocation is idempotent
     */
    public function testInvokeIsIdempotent(): void
    {
        $firstCall = ($this->defaultFileExtensions)();
        $secondCall = ($this->defaultFileExtensions)();

        self::assertSame($firstCall, $secondCall);
    }

    /**
     * Test that invocation returns indexed array
     */
    public function testInvokeReturnsIndexedArray(): void
    {
        $actual = ($this->defaultFileExtensions)();

        self::assertSame(array_values($actual), $actual);
    }

    /**
     * Test that all values are strings
     */
    public function testInvokeAllValuesAreStrings(): void
    {
        $actual = ($this->defaultFileExtensions)();

        foreach ($actual as $value) {
            self::assertIsString($value);
        }
    }

    /**
     * Test that all values are non-empty
     */
    public function testInvokeAllValuesAreNonEmpty(): void
    {
        $actual = ($this->defaultFileExtensions)();

        foreach ($actual as $value) {
            self::assertNotEmpty($value);
        }
    }
}
