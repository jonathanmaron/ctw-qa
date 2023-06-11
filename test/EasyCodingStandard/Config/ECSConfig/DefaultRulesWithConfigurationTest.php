<?php declare(strict_types=1);

namespace CtwTest\Unit\Qa\EasyCodingStandard\Config\ECSConfig;

use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultRulesWithConfiguration;
use PHPUnit\Framework\TestCase;

/**
 * Class DefaultRulesWithConfigurationTest.
 */
final class DefaultRulesWithConfigurationTest extends TestCase
{
    private DefaultRulesWithConfiguration $defaultRulesWithConfiguration;


    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->defaultRulesWithConfiguration = new DefaultRulesWithConfiguration();
    }


    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->defaultRulesWithConfiguration);
    }

    public function testInvoke(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
