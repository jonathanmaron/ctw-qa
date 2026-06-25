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
     * Test that invocation returns the LF character ("\n") expected by ECS configuration.
     */
    public function testInvokeReturnsLineFeedCharacter(): void
    {
        $expected = "\n";

        $actual = $this->value();

        self::assertSame($expected, $actual);
    }

    /**
     * Test that invocation returns a non-empty string so ECS does not reject the setting.
     */
    public function testInvokeReturnsNonEmptyString(): void
    {
        $actual = $this->value();

        self::assertNotEmpty($actual);
    }

    /**
     * Test that invocation returns a single character, ruling out multi-character sequences.
     */
    public function testInvokeReturnsSingleCharacter(): void
    {
        $actual = $this->value();

        self::assertSame(1, strlen($actual));
    }

    /**
     * Test that invocation never returns a Windows-style CRLF sequence.
     */
    public function testInvokeDoesNotReturnCarriageReturnLineFeed(): void
    {
        $actual = $this->value();

        self::assertNotSame("\r\n", $actual);
    }

    /**
     * Test that invocation never returns a bare carriage return.
     */
    public function testInvokeDoesNotReturnCarriageReturn(): void
    {
        $actual = $this->value();

        self::assertNotSame("\r", $actual);
    }

    /**
     * Test that invocation produces the same result when called more than once.
     */
    public function testInvokeIsIdempotentAcrossRepeatedCalls(): void
    {
        $firstCall  = $this->value();
        $secondCall = $this->value();

        self::assertSame($firstCall, $secondCall);
    }

    /**
     * Returns the invocation result as a plain string so the assertions
     * exercise the runtime value rather than its narrowed literal type.
     */
    private function value(): string
    {
        return ($this->defaultLineEnding)();
    }
}
