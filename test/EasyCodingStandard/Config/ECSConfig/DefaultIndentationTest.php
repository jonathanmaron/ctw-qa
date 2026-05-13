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
     * Test that invocation returns the literal 'spaces' value expected by ECS configuration.
     */
    public function testInvokeReturnsSpacesLiteral(): void
    {
        $expected = 'spaces';

        $actual = ($this->defaultIndentation)();

        self::assertSame($expected, $actual);
    }

    /**
     * Test that invocation returns a non-empty string so ECS does not reject the setting.
     */
    public function testInvokeReturnsNonEmptyString(): void
    {
        $actual = ($this->defaultIndentation)();

        self::assertNotEmpty($actual);
    }

    /**
     * Test that invocation returns a fully lowercase string, matching ECS's expected casing.
     */
    public function testInvokeReturnsLowercaseString(): void
    {
        $actual = ($this->defaultIndentation)();

        self::assertSame(strtolower($actual), $actual);
    }

    /**
     * Test that invocation does not return 'tabs', since the project standard is spaces.
     */
    public function testInvokeDoesNotReturnTabs(): void
    {
        $actual = ($this->defaultIndentation)();

        self::assertNotSame('tabs', $actual);
    }

    /**
     * Test that invocation produces the same result when called more than once.
     */
    public function testInvokeIsIdempotentAcrossRepeatedCalls(): void
    {
        $firstCall  = ($this->defaultIndentation)();
        $secondCall = ($this->defaultIndentation)();

        self::assertSame($firstCall, $secondCall);
    }
}
