<?php

declare(strict_types=1);

namespace CtwTest\Qa\ComposerDependencyAnalyser\Config\Configuration;

use Ctw\Qa\ComposerDependencyAnalyser\Config\Configuration\DefaultIgnoredUnknownClassPatterns;
use PHPUnit\Framework\TestCase;

final class DefaultIgnoredUnknownClassPatternsTest extends TestCase
{
    private DefaultIgnoredUnknownClassPatterns $defaultIgnoredUnknownClassPatterns;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultIgnoredUnknownClassPatterns = new DefaultIgnoredUnknownClassPatterns();
    }

    /**
     * Test that invocation returns the full expected list of patterns in source order.
     */
    public function testInvokeReturnsExpectedPatternsInSourceOrder(): void
    {
        $expected = [
            '/^PHP_CodeSniffer\\\\/',
            '/^PhpCsFixer\\\\/',
        ];

        $actual = ($this->defaultIgnoredUnknownClassPatterns)();

        self::assertSame($expected, $actual);
    }

    /**
     * Test that invocation never returns an empty array, since the curated pattern list always has entries.
     */
    public function testInvokeReturnsNonEmptyArray(): void
    {
        $actual = ($this->defaultIgnoredUnknownClassPatterns)();

        self::assertNotEmpty($actual);
    }

    /**
     * Test that invocation returns exactly two patterns, pinning the curated pattern count.
     */
    public function testInvokeReturnsExactlyTwoPatterns(): void
    {
        $actual = ($this->defaultIgnoredUnknownClassPatterns)();

        self::assertCount(2, $actual);
    }

    /**
     * Test that every returned pattern compiles, since the analyser passes it straight to preg_match().
     */
    public function testInvokeAllPatternsCompile(): void
    {
        $actual = ($this->defaultIgnoredUnknownClassPatterns)();

        foreach ($actual as $pattern) {
            self::assertIsInt(@preg_match($pattern, 'Acme\Example'));
        }
    }

    /**
     * Test that the PHP_CodeSniffer pattern matches the sniffs named in the coding standard configuration.
     */
    public function testInvokePhpCodeSnifferPatternMatchesItsSniffs(): void
    {
        $actual = ($this->defaultIgnoredUnknownClassPatterns)();

        self::assertMatchesRegularExpression($actual[0], 'PHP_CodeSniffer\Sniffs\Sniff');
        self::assertMatchesRegularExpression(
            $actual[0],
            'PHP_CodeSniffer\Standards\Generic\Sniffs\Arrays\DisallowLongArraySyntaxSniff'
        );
    }

    /**
     * Test that the PHP CS Fixer pattern matches the fixers named in the coding standard configuration.
     */
    public function testInvokePhpCsFixerPatternMatchesItsFixers(): void
    {
        $actual = ($this->defaultIgnoredUnknownClassPatterns)();

        self::assertMatchesRegularExpression($actual[1], 'PhpCsFixer\Fixer\FixerInterface');
        self::assertMatchesRegularExpression($actual[1], 'PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer');
    }

    /**
     * Test that the patterns are anchored to the namespace, so an unrelated class is never excluded.
     */
    public function testInvokePatternsDoNotMatchUnrelatedClasses(): void
    {
        $actual = ($this->defaultIgnoredUnknownClassPatterns)();

        foreach ($actual as $pattern) {
            self::assertDoesNotMatchRegularExpression($pattern, 'Acme\Config\AcmeConfig');
            self::assertDoesNotMatchRegularExpression($pattern, 'Acme\PhpCsFixer\Fixer\CustomFixer');
            self::assertDoesNotMatchRegularExpression($pattern, 'Acme\PHP_CodeSniffer\Sniffs\CustomSniff');
        }
    }

    /**
     * Test that a namespace merely prefixed with one of ours is not matched, the separator being required.
     */
    public function testInvokePatternsRequireTheNamespaceSeparator(): void
    {
        $actual = ($this->defaultIgnoredUnknownClassPatterns)();

        self::assertDoesNotMatchRegularExpression($actual[0], 'PHP_CodeSnifferExtra\Sniff');
        self::assertDoesNotMatchRegularExpression($actual[1], 'PhpCsFixerExtra\Fixer');
    }

    /**
     * Test that every returned pattern is delimited, since the analyser adds no delimiters of its own.
     */
    public function testInvokeAllPatternsAreDelimited(): void
    {
        $actual = ($this->defaultIgnoredUnknownClassPatterns)();

        foreach ($actual as $pattern) {
            self::assertStringStartsWith('/', $pattern);
            self::assertStringEndsWith('/', $pattern);
        }
    }

    /**
     * Test that invocation returns a zero-indexed (list-style) array.
     */
    public function testInvokeReturnsIndexedArray(): void
    {
        $actual = ($this->defaultIgnoredUnknownClassPatterns)();

        self::assertSame(array_values($actual), $actual);
    }

    /**
     * Test that invocation returns no duplicate patterns.
     */
    public function testInvokeReturnsUniquePatterns(): void
    {
        $actual = ($this->defaultIgnoredUnknownClassPatterns)();

        self::assertSame(array_values(array_unique($actual)), $actual);
    }

    /**
     * Test that every returned pattern is a non-empty string, since an empty one matches everything.
     */
    public function testInvokeAllValuesAreNonEmptyStrings(): void
    {
        $actual = ($this->defaultIgnoredUnknownClassPatterns)();

        foreach ($actual as $value) {
            self::assertNotEmpty($value);
        }
    }

    /**
     * Test that invocation produces the same result when called more than once.
     */
    public function testInvokeIsIdempotentAcrossRepeatedCalls(): void
    {
        $firstCall  = ($this->defaultIgnoredUnknownClassPatterns)();
        $secondCall = ($this->defaultIgnoredUnknownClassPatterns)();

        self::assertSame($firstCall, $secondCall);
    }
}
