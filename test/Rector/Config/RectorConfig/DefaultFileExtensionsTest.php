<?php

declare(strict_types=1);

namespace CtwTest\Qa\Rector\Config\RectorConfig;

use Ctw\Qa\Rector\Config\RectorConfig\DefaultFileExtensions;
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
     * Test that invocation returns the canonical ['php', 'phtml'] list in source order.
     */
    public function testInvokeReturnsPhpAndPhtmlInOrder(): void
    {
        $expected = ['php', 'phtml'];

        $actual = ($this->defaultFileExtensions)();

        self::assertSame($expected, $actual);
    }

    /**
     * Test that invocation never returns an empty array, since Rector requires at least one extension.
     */
    public function testInvokeReturnsNonEmptyArray(): void
    {
        $actual = ($this->defaultFileExtensions)();

        self::assertNotEmpty($actual);
    }

    /**
     * Test that invocation returns exactly two extensions, pinning the supported file types.
     */
    public function testInvokeReturnsExactlyTwoExtensions(): void
    {
        $actual = ($this->defaultFileExtensions)();

        self::assertCount(2, $actual);
    }

    /**
     * Test that invocation includes the 'php' extension for plain PHP files.
     */
    public function testInvokeIncludesPhpExtension(): void
    {
        $actual = ($this->defaultFileExtensions)();

        self::assertContains('php', $actual);
    }

    /**
     * Test that invocation includes the 'phtml' extension for templating files.
     */
    public function testInvokeIncludesPhtmlExtension(): void
    {
        $actual = ($this->defaultFileExtensions)();

        self::assertContains('phtml', $actual);
    }

    /**
     * Test that invocation returns no duplicate extensions.
     */
    public function testInvokeReturnsUniqueExtensions(): void
    {
        $actual = ($this->defaultFileExtensions)();

        self::assertSame(array_values(array_unique($actual)), $actual);
    }

    /**
     * Test that invocation produces the same result when called more than once.
     */
    public function testInvokeIsIdempotentAcrossRepeatedCalls(): void
    {
        $firstCall  = ($this->defaultFileExtensions)();
        $secondCall = ($this->defaultFileExtensions)();

        self::assertSame($firstCall, $secondCall);
    }

    /**
     * Test that invocation returns a zero-indexed (list-style) array.
     */
    public function testInvokeReturnsIndexedArray(): void
    {
        $actual = ($this->defaultFileExtensions)();

        self::assertSame(array_values($actual), $actual);
    }

    /**
     * Test that every returned extension is a non-empty string, since Rector rejects empty patterns.
     */
    public function testInvokeAllValuesAreNonEmptyStrings(): void
    {
        $actual = ($this->defaultFileExtensions)();

        foreach ($actual as $value) {
            self::assertNotEmpty($value);
        }
    }

    /**
     * Test that no returned extension contains a leading dot, since Rector expects bare extensions.
     */
    public function testInvokeExtensionsHaveNoLeadingDot(): void
    {
        $actual = ($this->defaultFileExtensions)();

        foreach ($actual as $value) {
            self::assertStringStartsNotWith('.', $value);
        }
    }
}
