<?php declare(strict_types=1);

namespace CtwTest\Unit\Qa\EasyCodingStandard\Config\ECSConfig;

use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultIndentation;
use PHPUnit\Framework\TestCase;

/**
 * Class DefaultIndentationTest.
 */
final class DefaultIndentationTest extends TestCase
{
    private DefaultIndentation $defaultIndentation;


    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->defaultIndentation = new DefaultIndentation();
    }


    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->defaultIndentation);
    }

    public function testInvoke(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
