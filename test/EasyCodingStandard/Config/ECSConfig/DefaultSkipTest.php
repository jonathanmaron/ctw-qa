<?php declare(strict_types=1);

namespace CtwTest\Unit\Qa\EasyCodingStandard\Config\ECSConfig;

use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultSkip;
use PHPUnit\Framework\TestCase;

/**
 * Class DefaultSkipTest.
 */
final class DefaultSkipTest extends TestCase
{
    private DefaultSkip $defaultSkip;


    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->defaultSkip = new DefaultSkip();
    }


    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->defaultSkip);
    }

    public function testInvoke(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
