<?php

declare(strict_types=1);

namespace CtwTest\Qa\EasyCodingStandard\Config\ECSConfig;

use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultLineEnding;
use PHPUnit\Framework\TestCase;

final class DefaultLineEndingTest extends TestCase
{
    private DefaultLineEnding $defaultLineEnding;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultLineEnding = new DefaultLineEnding();
    }

    /**
     * Test that invocation returns expected line ending value
     */
    public function testInvokeReturnsExpectedValue(): void
    {
        $expected = "\n";

        $actual = ($this->defaultLineEnding)();

        self::assertSame($expected, $actual);
    }

    /**
     * Test that invocation returns non-empty string
     */
    public function testInvokeReturnsNonEmptyString(): void
    {
        $actual = ($this->defaultLineEnding)();

        self::assertNotEmpty($actual);
    }

    /**
     * Test that invocation returns single character
     */
    public function testInvokeReturnsSingleCharacter(): void
    {
        $actual = ($this->defaultLineEnding)();

        self::assertSame(1, strlen($actual));
    }

    /**
     * Test that invocation returns newline character
     */
    public function testInvokeReturnsNewlineCharacter(): void
    {
        $actual = ($this->defaultLineEnding)();

        self::assertSame("\n", $actual);
    }

    /**
     * Test that invocation returns LF line ending not CRLF
     */
    public function testInvokeReturnsLfNotCrlf(): void
    {
        $actual = ($this->defaultLineEnding)();

        self::assertNotSame("\r\n", $actual);
        self::assertSame("\n", $actual);
    }

    /**
     * Test that invocation is idempotent
     */
    public function testInvokeIsIdempotent(): void
    {
        $firstCall = ($this->defaultLineEnding)();
        $secondCall = ($this->defaultLineEnding)();

        self::assertSame($firstCall, $secondCall);
    }

    /**
     * Test that invocation returns Unix-style line ending
     */
    public function testInvokeReturnsUnixStyleLineEnding(): void
    {
        $actual = ($this->defaultLineEnding)();

        self::assertSame(PHP_EOL === "\n" ? PHP_EOL : "\n", $actual);
    }
}
