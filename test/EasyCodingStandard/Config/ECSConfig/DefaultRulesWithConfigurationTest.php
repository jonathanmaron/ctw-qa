<?php

declare(strict_types=1);

namespace CtwTest\Qa\EasyCodingStandard\Config\ECSConfig;

use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultRulesWithConfiguration;
use PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer;
use PhpCsFixer\Fixer\FunctionNotation\MethodArgumentSpaceFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PHPUnit\Framework\TestCase;

final class DefaultRulesWithConfigurationTest extends TestCase
{
    private DefaultRulesWithConfiguration $defaultRulesWithConfiguration;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultRulesWithConfiguration = new DefaultRulesWithConfiguration();
    }

    /**
     * Test that invocation returns the full expected configured-rules map.
     */
    public function testInvokeReturnsExpectedRulesWithConfiguration(): void
    {
        $expected = [
            OrderedImportsFixer::class      => [
                'sort_algorithm' => 'alpha',
                'imports_order'  => ['class', 'function', 'const'],
            ],
            MethodArgumentSpaceFixer::class => [
                'on_multiline' => 'ignore',
            ],
            YodaStyleFixer::class => [
                'equal'            => true,
                'identical'        => true,
                'less_and_greater' => true,
            ],
        ];

        $actual = ($this->defaultRulesWithConfiguration)();

        self::assertSame($expected, $actual);
    }

    /**
     * Test that invocation never returns an empty array.
     */
    public function testInvokeReturnsNonEmptyArray(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();

        self::assertNotEmpty($actual);
    }

    /**
     * Test that invocation returns exactly three configured rules, pinning the curated count.
     */
    public function testInvokeReturnsExactlyThreeRules(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();

        self::assertCount(3, $actual);
    }

    /**
     * Test that invocation includes OrderedImportsFixer with its alphabetised, class/function/const ordering.
     */
    public function testInvokeIncludesOrderedImportsFixerWithConfiguration(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();

        self::assertArrayHasKey(OrderedImportsFixer::class, $actual);
        self::assertSame('alpha', $actual[OrderedImportsFixer::class]['sort_algorithm']);
        self::assertSame(['class', 'function', 'const'], $actual[OrderedImportsFixer::class]['imports_order']);
    }

    /**
     * Test that invocation includes MethodArgumentSpaceFixer with multiline handling set to ignore.
     */
    public function testInvokeIncludesMethodArgumentSpaceFixerWithConfiguration(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();

        self::assertArrayHasKey(MethodArgumentSpaceFixer::class, $actual);
        self::assertSame('ignore', $actual[MethodArgumentSpaceFixer::class]['on_multiline']);
    }

    /**
     * Test that invocation includes YodaStyleFixer with all comparison flags enabled.
     */
    public function testInvokeIncludesYodaStyleFixerWithConfiguration(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();

        self::assertArrayHasKey(YodaStyleFixer::class, $actual);
        self::assertTrue($actual[YodaStyleFixer::class]['equal']);
        self::assertTrue($actual[YodaStyleFixer::class]['identical']);
        self::assertTrue($actual[YodaStyleFixer::class]['less_and_greater']);
    }

    /**
     * Test that every configured rule key is namespaced under PhpCsFixer\, with no foreign keys.
     */
    public function testInvokeAllKeysUsePhpCsFixerNamespace(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();

        foreach (array_keys($actual) as $key) {
            self::assertStringStartsWith('PhpCsFixer\\', $key);
        }
    }

    /**
     * Test that every rule's configuration array is non-empty, since empty configs are ineffective.
     */
    public function testInvokeAllConfigurationArraysAreNonEmpty(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();

        foreach ($actual as $configuration) {
            self::assertNotEmpty($configuration);
        }
    }

    /**
     * Test that invocation produces the same result when called more than once.
     */
    public function testInvokeIsIdempotentAcrossRepeatedCalls(): void
    {
        $firstCall  = ($this->defaultRulesWithConfiguration)();
        $secondCall = ($this->defaultRulesWithConfiguration)();

        self::assertSame($firstCall, $secondCall);
    }

    /**
     * Test that the OrderedImportsFixer config exposes exactly the two expected keys.
     */
    public function testInvokeOrderedImportsFixerConfigurationHasCorrectStructure(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();
        $config = $actual[OrderedImportsFixer::class];

        self::assertArrayHasKey('sort_algorithm', $config);
        self::assertArrayHasKey('imports_order', $config);
        self::assertCount(2, $config);
    }

    /**
     * Test that the MethodArgumentSpaceFixer config exposes exactly the single expected key.
     */
    public function testInvokeMethodArgumentSpaceFixerConfigurationHasCorrectStructure(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();
        $config = $actual[MethodArgumentSpaceFixer::class];

        self::assertArrayHasKey('on_multiline', $config);
        self::assertCount(1, $config);
    }

    /**
     * Test that the YodaStyleFixer config exposes exactly the three expected flag keys.
     */
    public function testInvokeYodaStyleFixerConfigurationHasCorrectStructure(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();
        $config = $actual[YodaStyleFixer::class];

        self::assertArrayHasKey('equal', $config);
        self::assertArrayHasKey('identical', $config);
        self::assertArrayHasKey('less_and_greater', $config);
        self::assertCount(3, $config);
    }

    /**
     * Test that every configured rule key is unique (PHP guarantees this; the assertion documents the invariant).
     */
    public function testInvokeReturnsUniqueRuleKeys(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();
        $keys   = array_keys($actual);

        self::assertSame(array_values(array_unique($keys)), $keys);
    }
}
