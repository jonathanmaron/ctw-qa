<?php declare(strict_types=1);

namespace CtwTest\Unit\Qa\Rector\Config\RectorConfig;

use Ctw\Qa\Rector\Config\RectorConfig\DefaultFileExtensions;
use PHPUnit\Framework\TestCase;

/**
 * Class DefaultFileExtensionsTest.
 */
final class DefaultFileExtensionsTest extends TestCase
{
    private DefaultFileExtensions $defaultFileExtensions;


    protected function setUp(): void
    {
        parent::setUp();

        /** @todo Correctly instantiate tested object to use it. */
        $this->defaultFileExtensions = new DefaultFileExtensions();
    }


    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->defaultFileExtensions);
    }

    public function testInvoke(): void
    {
        /** @todo This test is incomplete. */
        $this->markTestIncomplete();
    }
}
