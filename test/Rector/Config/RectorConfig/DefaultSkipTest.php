<?php

declare(strict_types=1);

namespace CtwTest\Qa\Rector\Config\RectorConfig;

use Ctw\Qa\Rector\Config\RectorConfig\DefaultSkip;
use PHPUnit\Framework\TestCase;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector;
use Rector\Php81\Rector\FuncCall\NullToStrictStringFuncCallArgRector;

final class DefaultSkipTest extends TestCase
{
    private DefaultSkip $defaultSkip;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultSkip = new DefaultSkip();
    }

    /**
     * Test that invocation returns non-empty array
     */
    public function testInvokeReturnsNonEmptyArray(): void
    {
        $actual = ($this->defaultSkip)();

        self::assertNotEmpty($actual);
    }

    /**
     * Test that invocation includes common project directories
     */
    public function testInvokeIncludesCommonProjectDirectories(): void
    {
        $actual = ($this->defaultSkip)();

        self::assertContains('*/build/*', $actual);
        self::assertContains('*/compiled/*', $actual);
        self::assertContains('*/doc/*', $actual);
        self::assertContains('*/docs/*', $actual);
        self::assertContains('*/node_modules/*', $actual);
        self::assertContains('*/vendor/*', $actual);
    }

    /**
     * Test that invocation includes UP_TO_PHP_81 skipped rules
     */
    public function testInvokeIncludesUpToPhp81SkippedRules(): void
    {
        $actual = ($this->defaultSkip)();

        self::assertContains(NullToStrictStringFuncCallArgRector::class, $actual);
    }

    /**
     * Test that invocation includes NAMING skipped rules
     */
    public function testInvokeIncludesNamingSkippedRules(): void
    {
        $actual = ($this->defaultSkip)();

        self::assertContains(RenameParamToMatchTypeRector::class, $actual);
        self::assertContains(RenameVariableToMatchMethodCallReturnTypeRector::class, $actual);
        self::assertContains(RenameVariableToMatchNewTypeRector::class, $actual);
    }

    /**
     * Test that invocation includes CODING_STYLE associative entries
     */
    public function testInvokeIncludesCodingStyleAssociativeEntries(): void
    {
        $actual = ($this->defaultSkip)();

        self::assertArrayHasKey(NewlineAfterStatementRector::class, $actual);
    }

    /**
     * Test that invocation contains string keys for phtml specific rules
     */
    public function testInvokeContainsStringKeysForPhtmlSpecificRules(): void
    {
        $actual = ($this->defaultSkip)();

        self::assertArrayHasKey(NewlineAfterStatementRector::class, $actual);
        self::assertSame('*.phtml', $actual[NewlineAfterStatementRector::class]);
    }

    /**
     * Test that invocation is idempotent
     */
    public function testInvokeIsIdempotent(): void
    {
        $firstCall = ($this->defaultSkip)();
        $secondCall = ($this->defaultSkip)();

        self::assertSame($firstCall, $secondCall);
    }

    /**
     * Test that invocation contains expected minimum number of items
     */
    public function testInvokeContainsMinimumNumberOfItems(): void
    {
        $actual = ($this->defaultSkip)();

        self::assertGreaterThanOrEqual(10, count($actual));
    }

    /**
     * Test that string values are non-empty
     */
    public function testInvokeStringValuesAreNonEmpty(): void
    {
        $actual = ($this->defaultSkip)();

        foreach ($actual as $key => $value) {
            if (is_string($value)) {
                self::assertNotEmpty($value);
            }
        }
    }
}
