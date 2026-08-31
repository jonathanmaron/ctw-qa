<?php

declare(strict_types=1);

namespace CtwTest\Qa\ComposerDependencyAnalyser\Config\Configuration;

use Ctw\Qa\ComposerDependencyAnalyser\Config\Configuration\DefaultFileExtensions;
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
     * Test that invocation returns the full expected list of extensions in source order.
     */
    public function testInvokeReturnsPhpAndPhtmlInOrder(): void
    {
        $expected = ['php', 'phtml'];

        $actual = ($this->defaultFileExtensions)();

        self::assertSame($expected, $actual);
    }

    /**
     * Test that invocation never returns an empty array, since the analyser would then scan nothing.
     */
    public function testInvokeReturnsNonEmptyArray(): void
    {
        $actual = ($this->defaultFileExtensions)();

        self::assertNotEmpty($actual);
    }

    /**
     * Test that invocation returns exactly two extensions, pinning the curated extension count.
     */
    public function testInvokeReturnsExactlyTwoExtensions(): void
    {
        $actual = ($this->defaultFileExtensions)();

        self::assertCount(2, $actual);
    }

    /**
     * Test that plain PHP is included, since the analyser is otherwise blind to the source itself.
     */
    public function testInvokeIncludesPhpExtension(): void
    {
        $actual = ($this->defaultFileExtensions)();

        self::assertContains('php', $actual);
    }

    /**
     * Test that templates are included, which is what the analyser's own default leaves out.
     */
    public function testInvokeIncludesPhtmlExtension(): void
    {
        $actual = ($this->defaultFileExtensions)();

        self::assertContains('phtml', $actual);
    }

    /**
     * Test that no extension carries a leading dot, which setFileExtensions() does not expect.
     */
    public function testInvokeExtensionsHaveNoLeadingDot(): void
    {
        $actual = ($this->defaultFileExtensions)();

        foreach ($actual as $extension) {
            self::assertStringStartsNotWith('.', $extension);
        }
    }

    /**
     * Test that every extension is lower case, since the analyser compares them verbatim.
     */
    public function testInvokeExtensionsAreLowerCase(): void
    {
        $actual = ($this->defaultFileExtensions)();

        foreach ($actual as $extension) {
            self::assertSame(strtolower($extension), $extension);
        }
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
     * Test that invocation returns no duplicate extensions.
     */
    public function testInvokeReturnsUniqueExtensions(): void
    {
        $actual = ($this->defaultFileExtensions)();

        self::assertSame(array_values(array_unique($actual)), $actual);
    }

    /**
     * Test that every returned extension is a non-empty string, since an empty one matches nothing.
     */
    public function testInvokeAllValuesAreNonEmptyStrings(): void
    {
        $actual = ($this->defaultFileExtensions)();

        foreach ($actual as $value) {
            self::assertNotEmpty($value);
        }
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
}
