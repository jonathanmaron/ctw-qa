<?php declare(strict_types=1);

namespace CtwTest\Unit\Qa\Rector\Config\RectorConfig;

use Ctw\Qa\Rector\Config\RectorConfig\DefaultSets;
use PHPUnit\Framework\TestCase;

/**
 * Class DefaultSetsTest.
 */
final class DefaultSetsTest extends TestCase
{
    private DefaultSets $defaultSets;


    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->defaultSets = new DefaultSets();
    }


    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->defaultSets);
    }

    public function testInvoke(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
