<?php

declare(strict_types=1);

namespace CtwTest\Qa\EasyCodingStandard\Config\ECSConfig;

use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultSkip;
use PhpCsFixer\Fixer\Basic\BracesFixer;
use PhpCsFixer\Fixer\ClassNotation\NoBlankLinesAfterClassOpeningFixer;
use PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionDeclarationFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\Whitespace\NoExtraBlankLinesFixer;
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
     * Test that invocation never returns an empty array, since the curated skip list always has entries.
     */
    public function testInvokeReturnsNonEmptyArray(): void
    {
        $actual = ($this->defaultSkip)();

        self::assertNotEmpty($actual);
    }

    /**
     * Test that invocation includes all common project directory glob patterns.
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
     * Test that invocation includes COMMON skipped rules.
     */
    public function testInvokeIncludesCommonSkippedRules(): void
    {
        $actual = ($this->defaultSkip)();

        self::assertContains(NotOperatorWithSuccessorSpaceFixer::class, $actual);
    }

    /**
     * Test that invocation includes the indexed PSR-12 skipped rules.
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
     * Test that invocation maps StatementIndentationFixer to *.phtml templates only.
     */
    public function testInvokeMapsStatementIndentationFixerToPhtmlOnly(): void
    {
        $actual = ($this->defaultSkip)();

        self::assertArrayHasKey(StatementIndentationFixer::class, $actual);
        self::assertIsArray($actual[StatementIndentationFixer::class]);
        self::assertSame(['*.phtml'], $actual[StatementIndentationFixer::class]);
    }

    /**
     * Test that invocation includes the personal-preference skipped rules, the fourth curated skip category.
     */
    public function testInvokeIncludesPersonalPreferenceRules(): void
    {
        $actual = ($this->defaultSkip)();

        self::assertContains(NoBlankLinesAfterClassOpeningFixer::class, $actual);
        self::assertContains(NoExtraBlankLinesFixer::class, $actual);
    }

    /**
     * Test that invocation produces the same result when called more than once.
     */
    public function testInvokeIsIdempotentAcrossRepeatedCalls(): void
    {
        $firstCall  = ($this->defaultSkip)();
        $secondCall = ($this->defaultSkip)();

        self::assertSame($firstCall, $secondCall);
    }

    /**
     * Test that invocation returns exactly the curated 15 skip entries (6 project + 1 common + 6 PSR-12 + 2 personal).
     */
    public function testInvokeReturnsFifteenSkipEntries(): void
    {
        $actual = ($this->defaultSkip)();

        self::assertCount(15, $actual);
    }

    /**
     * Test that every string value in the returned array is non-empty.
     */
    public function testInvokeStringValuesAreNonEmpty(): void
    {
        $actual = ($this->defaultSkip)();

        foreach ($actual as $value) {
            if (is_string($value)) {
                self::assertNotEmpty($value);
            }
        }
    }

    /**
     * Test that all six project directory patterns use the leading and trailing wildcard format.
     */
    public function testInvokeProjectDirectoryPatternsUseWildcardFormat(): void
    {
        $actual             = ($this->defaultSkip)();
        $projectDirectories = array_filter($actual, static fn(mixed $value): bool => is_string($value) && str_starts_with($value, '*/') && str_ends_with($value, '/*'));

        self::assertCount(6, $projectDirectories);
    }

    /**
     * Test that all eight fixer class strings (excluding the keyed entry) live under PhpCsFixer\.
     */
    public function testInvokeFixerClassNamesUsePhpCsFixerNamespace(): void
    {
        $actual       = ($this->defaultSkip)();
        $stringValues = array_filter($actual, is_string(...));
        $fixerClasses = array_filter($stringValues, static fn(string $value): bool => str_contains($value, '\\Fixer\\'));

        self::assertCount(8, $fixerClasses);

        foreach ($fixerClasses as $fixerClass) {
            self::assertStringStartsWith('PhpCsFixer\\', $fixerClass);
        }
    }

    /**
     * Test that the indexed (numeric-key) string values contain no duplicates.
     */
    public function testInvokeIndexedStringValuesAreUnique(): void
    {
        $actual = ($this->defaultSkip)();

        $indexedValues = [];
        foreach ($actual as $key => $value) {
            if (is_int($key) && is_string($value)) {
                $indexedValues[] = $value;
            }
        }

        self::assertSame(array_values(array_unique($indexedValues)), $indexedValues);
    }
}
