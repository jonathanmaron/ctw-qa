<?php
declare(strict_types=1);

namespace CtwTest\Unit\Qa\EasyCodingStandard\Config\ECSConfig;

use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultRules;
use PHPUnit\Framework\TestCase;

final class DefaultRulesTest extends TestCase
{
    private DefaultRules $defaultRules;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultRules = new DefaultRules();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->defaultRules);
    }

    public function testInvoke(): void
    {
        $config = $this->defaultRules->__invoke();

        foreach ($config as $value) {
            self::assertTrue(str_starts_with($value, 'PhpCsFixer') || str_starts_with($value, 'PHP_CodeSniffer'));
        }
    }
}
