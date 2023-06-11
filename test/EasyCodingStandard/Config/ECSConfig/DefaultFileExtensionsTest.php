<?php
declare(strict_types=1);

namespace CtwTest\Unit\Qa\EasyCodingStandard\Config\ECSConfig;

use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultFileExtensions;
use PHPUnit\Framework\TestCase;

final class DefaultFileExtensionsTest extends TestCase
{
    private DefaultFileExtensions $defaultFileExtensions;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultFileExtensions = new DefaultFileExtensions();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->defaultFileExtensions);
    }

    public function testInvoke(): void
    {
        $config = $this->defaultFileExtensions->__invoke();

        self::assertIsArray($config);
        self::assertNotEmpty($config);
        self::assertTrue(in_array('php', $config, true));
    }
}
