<?php declare(strict_types=1);

namespace CtwTest\Unit\Qa\EasyCodingStandard\Config\ECSConfig;

use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultRules;
use PHPUnit\Framework\TestCase;

/**
 * Class DefaultRulesTest.
 */
final class DefaultRulesTest extends TestCase
{
    private DefaultRules $defaultRules;


    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->defaultRules = new DefaultRules();
    }


    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->defaultRules);
    }

    public function testInvoke(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
