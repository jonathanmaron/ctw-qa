<?php declare(strict_types=1);

namespace CtwTest\Unit\Qa\EasyCodingStandard\Config\ECSConfig;

use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultLineEnding;
use PHPUnit\Framework\TestCase;

/**
 * Class DefaultLineEndingTest.
 */
final class DefaultLineEndingTest extends TestCase
{
    private DefaultLineEnding $defaultLineEnding;


    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->defaultLineEnding = new DefaultLineEnding();
    }


    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->defaultLineEnding);
    }

    public function testInvoke(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
