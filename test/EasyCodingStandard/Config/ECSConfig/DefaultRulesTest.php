<?php

declare(strict_types=1);

namespace CtwTest\Qa\EasyCodingStandard\Config\ECSConfig;

use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultRules;
use PHP_CodeSniffer\Standards\Generic\Sniffs\Arrays\DisallowLongArraySyntaxSniff;
use PhpCsFixer\Fixer\ClassNotation\OrderedTraitsFixer;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\IsNullFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTypesOrderFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Strict\StrictComparisonFixer;
use PhpCsFixer\Fixer\Strict\StrictParamFixer;
use PHPUnit\Framework\TestCase;

final class DefaultRulesTest extends TestCase
{
    private DefaultRules $defaultRules;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultRules = new DefaultRules();
    }

    /**
     * Test that invocation returns expected rules
     */
    public function testInvokeReturnsExpectedRules(): void
    {
        $expected = [
            DeclareStrictTypesFixer::class,
            DisallowLongArraySyntaxSniff::class,
            IsNullFixer::class,
            NoUnusedImportsFixer::class,
            OrderedTraitsFixer::class,
            PhpdocTypesOrderFixer::class,
            StrictComparisonFixer::class,
            StrictParamFixer::class,
            TrailingCommaInMultilineFixer::class,
        ];

        $actual = ($this->defaultRules)();

        self::assertSame($expected, $actual);
    }

    /**
     * Test that invocation returns non-empty array
     */
    public function testInvokeReturnsNonEmptyArray(): void
    {
        $actual = ($this->defaultRules)();

        self::assertNotEmpty($actual);
    }

    /**
     * Test that invocation returns exactly nine rules
     */
    public function testInvokeReturnsExactlyNineRules(): void
    {
        $actual = ($this->defaultRules)();

        self::assertCount(9, $actual);
    }

    /**
     * Test that invocation includes DeclareStrictTypesFixer
     */
    public function testInvokeIncludesDeclareStrictTypesFixer(): void
    {
        $actual = ($this->defaultRules)();

        self::assertContains(DeclareStrictTypesFixer::class, $actual);
    }

    /**
     * Test that invocation includes DisallowLongArraySyntaxSniff
     */
    public function testInvokeIncludesDisallowLongArraySyntaxSniff(): void
    {
        $actual = ($this->defaultRules)();

        self::assertContains(DisallowLongArraySyntaxSniff::class, $actual);
    }

    /**
     * Test that invocation includes IsNullFixer
     */
    public function testInvokeIncludesIsNullFixer(): void
    {
        $actual = ($this->defaultRules)();

        self::assertContains(IsNullFixer::class, $actual);
    }

    /**
     * Test that invocation includes NoUnusedImportsFixer
     */
    public function testInvokeIncludesNoUnusedImportsFixer(): void
    {
        $actual = ($this->defaultRules)();

        self::assertContains(NoUnusedImportsFixer::class, $actual);
    }

    /**
     * Test that invocation includes OrderedTraitsFixer
     */
    public function testInvokeIncludesOrderedTraitsFixer(): void
    {
        $actual = ($this->defaultRules)();

        self::assertContains(OrderedTraitsFixer::class, $actual);
    }

    /**
     * Test that invocation includes PhpdocTypesOrderFixer
     */
    public function testInvokeIncludesPhpdocTypesOrderFixer(): void
    {
        $actual = ($this->defaultRules)();

        self::assertContains(PhpdocTypesOrderFixer::class, $actual);
    }

    /**
     * Test that invocation includes StrictComparisonFixer
     */
    public function testInvokeIncludesStrictComparisonFixer(): void
    {
        $actual = ($this->defaultRules)();

        self::assertContains(StrictComparisonFixer::class, $actual);
    }

    /**
     * Test that invocation includes StrictParamFixer
     */
    public function testInvokeIncludesStrictParamFixer(): void
    {
        $actual = ($this->defaultRules)();

        self::assertContains(StrictParamFixer::class, $actual);
    }

    /**
     * Test that invocation includes TrailingCommaInMultilineFixer
     */
    public function testInvokeIncludesTrailingCommaInMultilineFixer(): void
    {
        $actual = ($this->defaultRules)();

        self::assertContains(TrailingCommaInMultilineFixer::class, $actual);
    }

    /**
     * Test that all values are strings
     */
    public function testInvokeAllValuesAreStrings(): void
    {
        $actual = ($this->defaultRules)();

        foreach ($actual as $value) {
            self::assertIsString($value);
        }
    }

    /**
     * Test that all values use PhpCsFixer or PHP_CodeSniffer namespace
     */
    public function testInvokeAllValuesUseExpectedNamespaces(): void
    {
        $actual = ($this->defaultRules)();

        foreach ($actual as $value) {
            self::assertIsString($value);
            $isPhpCsFixer = str_starts_with($value, 'PhpCsFixer\\');
            $isPhpCodeSniffer = str_starts_with($value, 'PHP_CodeSniffer\\');

            self::assertTrue(
                $isPhpCsFixer || $isPhpCodeSniffer,
                "Value '{$value}' does not start with expected namespace"
            );
        }
    }

    /**
     * Test that invocation returns indexed array
     */
    public function testInvokeReturnsIndexedArray(): void
    {
        $actual = ($this->defaultRules)();

        self::assertSame(array_values($actual), $actual);
    }

    /**
     * Test that invocation is idempotent
     */
    public function testInvokeIsIdempotent(): void
    {
        $firstCall = ($this->defaultRules)();
        $secondCall = ($this->defaultRules)();

        self::assertSame($firstCall, $secondCall);
    }
}
