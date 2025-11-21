<?php

declare(strict_types=1);

namespace CtwTest\Qa\EasyCodingStandard\Config\ECSConfig;

use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultIndentation;
use PHPUnit\Framework\TestCase;

final class DefaultIndentationTest extends TestCase
{
    private DefaultIndentation $defaultIndentation;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultIndentation = new DefaultIndentation();
    }

    /**
     * Test that invocation returns expected indentation value
     */
    public function testInvokeReturnsExpectedValue(): void
    {
        $expected = 'spaces';

        $actual = ($this->defaultIndentation)();

        self::assertSame($expected, $actual);
    }

    /**
     * Test that invocation returns non-empty string
     */
    public function testInvokeReturnsNonEmptyString(): void
    {
        $actual = ($this->defaultIndentation)();

        self::assertNotEmpty($actual);
    }

    /**
     * Test that invocation returns lowercase string
     */
    public function testInvokeReturnsLowercaseString(): void
    {
        $actual = ($this->defaultIndentation)();

        self::assertSame(strtolower($actual), $actual);
    }

    /**
     * Test that invocation is idempotent
     */
    public function testInvokeIsIdempotent(): void
    {
        $firstCall = ($this->defaultIndentation)();
        $secondCall = ($this->defaultIndentation)();

        self::assertSame($firstCall, $secondCall);
    }

    /**
     * Test that invocation returns exactly 'spaces' value
     */
    public function testInvokeReturnsSpacesValue(): void
    {
        $actual = ($this->defaultIndentation)();

        self::assertSame('spaces', $actual);
    }
}
