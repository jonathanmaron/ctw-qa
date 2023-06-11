<?php declare(strict_types=1);

namespace CtwTest\Unit\Qa\EasyCodingStandard\Config\ECSConfig;

use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultRulesWithConfiguration;
use PHPUnit\Framework\TestCase;

final class DefaultRulesWithConfigurationTest extends TestCase
{
    private DefaultRulesWithConfiguration $defaultRulesWithConfiguration;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultRulesWithConfiguration = new DefaultRulesWithConfiguration();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->defaultRulesWithConfiguration);
    }

    public function testInvoke(): void
    {
        $config = $this->defaultRulesWithConfiguration->__invoke();

        foreach (array_keys($config) as $key) {
            self::assertTrue(str_starts_with($key, 'PhpCsFixer') || str_starts_with($key, 'PHP_CodeSniffer'));
        }
    }
}
