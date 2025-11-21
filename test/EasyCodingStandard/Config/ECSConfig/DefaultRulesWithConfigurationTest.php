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
     * Test that invocation returns expected rules with configuration
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
     * Test that invocation returns non-empty array
     */
    public function testInvokeReturnsNonEmptyArray(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();

        self::assertNotEmpty($actual);
    }

    /**
     * Test that invocation returns exactly three rules
     */
    public function testInvokeReturnsExactlyThreeRules(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();

        self::assertCount(3, $actual);
    }

    /**
     * Test that invocation includes OrderedImportsFixer with configuration
     */
    public function testInvokeIncludesOrderedImportsFixerWithConfiguration(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();

        self::assertArrayHasKey(OrderedImportsFixer::class, $actual);
        self::assertIsArray($actual[OrderedImportsFixer::class]);
        self::assertSame('alpha', $actual[OrderedImportsFixer::class]['sort_algorithm']);
        self::assertSame(['class', 'function', 'const'], $actual[OrderedImportsFixer::class]['imports_order']);
    }

    /**
     * Test that invocation includes MethodArgumentSpaceFixer with configuration
     */
    public function testInvokeIncludesMethodArgumentSpaceFixerWithConfiguration(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();

        self::assertArrayHasKey(MethodArgumentSpaceFixer::class, $actual);
        self::assertIsArray($actual[MethodArgumentSpaceFixer::class]);
        self::assertSame('ignore', $actual[MethodArgumentSpaceFixer::class]['on_multiline']);
    }

    /**
     * Test that invocation includes YodaStyleFixer with configuration
     */
    public function testInvokeIncludesYodaStyleFixerWithConfiguration(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();

        self::assertArrayHasKey(YodaStyleFixer::class, $actual);
        self::assertIsArray($actual[YodaStyleFixer::class]);
        self::assertTrue($actual[YodaStyleFixer::class]['equal']);
        self::assertTrue($actual[YodaStyleFixer::class]['identical']);
        self::assertTrue($actual[YodaStyleFixer::class]['less_and_greater']);
    }

    /**
     * Test that all keys are strings
     */
    public function testInvokeAllKeysAreStrings(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();

        foreach (array_keys($actual) as $key) {
            self::assertIsString($key);
        }
    }

    /**
     * Test that all keys use PhpCsFixer namespace
     */
    public function testInvokeAllKeysUsePhpCsFixerNamespace(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();

        foreach (array_keys($actual) as $key) {
            self::assertStringStartsWith('PhpCsFixer\\', $key);
        }
    }

    /**
     * Test that all values are arrays
     */
    public function testInvokeAllValuesAreArrays(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();

        foreach ($actual as $value) {
            self::assertIsArray($value);
        }
    }

    /**
     * Test that all configuration arrays are non-empty
     */
    public function testInvokeAllConfigurationArraysAreNonEmpty(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();

        foreach ($actual as $configuration) {
            self::assertNotEmpty($configuration);
        }
    }

    /**
     * Test that invocation returns associative array
     */
    public function testInvokeReturnsAssociativeArray(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();

        self::assertNotSame(array_values($actual), $actual);
    }

    /**
     * Test that invocation is idempotent
     */
    public function testInvokeIsIdempotent(): void
    {
        $firstCall = ($this->defaultRulesWithConfiguration)();
        $secondCall = ($this->defaultRulesWithConfiguration)();

        self::assertSame($firstCall, $secondCall);
    }

    /**
     * Test that OrderedImportsFixer configuration has correct structure
     */
    public function testInvokeOrderedImportsFixerConfigurationHasCorrectStructure(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();
        $config = $actual[OrderedImportsFixer::class];
        self::assertIsArray($config);

        self::assertArrayHasKey('sort_algorithm', $config);
        self::assertArrayHasKey('imports_order', $config);
        self::assertCount(2, $config);
    }

    /**
     * Test that MethodArgumentSpaceFixer configuration has correct structure
     */
    public function testInvokeMethodArgumentSpaceFixerConfigurationHasCorrectStructure(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();
        $config = $actual[MethodArgumentSpaceFixer::class];
        self::assertIsArray($config);

        self::assertArrayHasKey('on_multiline', $config);
        self::assertCount(1, $config);
    }

    /**
     * Test that YodaStyleFixer configuration has correct structure
     */
    public function testInvokeYodaStyleFixerConfigurationHasCorrectStructure(): void
    {
        $actual = ($this->defaultRulesWithConfiguration)();
        $config = $actual[YodaStyleFixer::class];
        self::assertIsArray($config);

        self::assertArrayHasKey('equal', $config);
        self::assertArrayHasKey('identical', $config);
        self::assertArrayHasKey('less_and_greater', $config);
        self::assertCount(3, $config);
    }
}
