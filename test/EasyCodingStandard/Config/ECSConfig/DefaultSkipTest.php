<?php

declare(strict_types=1);

namespace CtwTest\Qa\EasyCodingStandard\Config\ECSConfig;

use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultSkip;
use PhpCsFixer\Fixer\Basic\BracesFixer;
use PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionDeclarationFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\Whitespace\StatementIndentationFixer;
use PHPUnit\Framework\TestCase;

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
     * Test that invocation includes COMMON skipped rules
     */
    public function testInvokeIncludesCommonSkippedRules(): void
    {
        $actual = ($this->defaultSkip)();

        self::assertContains(NotOperatorWithSuccessorSpaceFixer::class, $actual);
    }

    /**
     * Test that invocation includes PSR_12 skipped rules
     */
    public function testInvokeIncludesPsr12SkippedRules(): void
    {
        $actual = ($this->defaultSkip)();

        self::assertContains(BinaryOperatorSpacesFixer::class, $actual);
        self::assertContains(BlankLineAfterOpeningTagFixer::class, $actual);
        self::assertContains(BracesFixer::class, $actual);
        self::assertContains(FunctionDeclarationFixer::class, $actual);
        self::assertContains(NoTrailingWhitespaceInCommentFixer::class, $actual);
    }

    /**
     * Test that invocation includes StatementIndentationFixer
     */
    public function testInvokeIncludesStatementIndentationFixer(): void
    {
        $actual = ($this->defaultSkip)();

        self::assertArrayHasKey(StatementIndentationFixer::class, $actual);
    }

    /**
     * Test that invocation contains string keys for phtml specific rules
     */
    public function testInvokeContainsStringKeysForPhtmlSpecificRules(): void
    {
        $actual = ($this->defaultSkip)();

        self::assertArrayHasKey(StatementIndentationFixer::class, $actual);
        self::assertIsArray($actual[StatementIndentationFixer::class]);
        self::assertContains('*.phtml', $actual[StatementIndentationFixer::class]);
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

        self::assertGreaterThanOrEqual(12, count($actual));
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

    /**
     * Test that project directory patterns use wildcard format
     */
    public function testInvokeProjectDirectoryPatternsUseWildcardFormat(): void
    {
        $actual = ($this->defaultSkip)();
        $projectDirectories = array_filter($actual, static function (mixed $value): bool {
            return is_string($value) && str_starts_with($value, '*/') && str_ends_with($value, '/*');
        });

        self::assertGreaterThanOrEqual(6, count($projectDirectories));
    }

    /**
     * Test that fixer class names use PhpCsFixer namespace
     */
    public function testInvokeFixerClassNamesUsePhpCsFixerNamespace(): void
    {
        $actual = ($this->defaultSkip)();
        $stringValues = array_filter($actual, static fn(mixed $value): bool => is_string($value));
        $fixerClasses = array_filter($stringValues, static function (string $value): bool {
            return str_contains($value, '\\Fixer\\');
        });

        self::assertGreaterThanOrEqual(6, count($fixerClasses));

        foreach ($fixerClasses as $fixerClass) {
            self::assertStringStartsWith('PhpCsFixer\\', $fixerClass);
        }
    }
}
