<?php declare(strict_types=1);

namespace CtwTest\Unit\Qa\Rector\Config\RectorConfig;

use Ctw\Qa\Rector\Config\RectorConfig\DefaultSets;
use PHPUnit\Framework\TestCase;

final class DefaultSetsTest extends TestCase
{
    private DefaultSets $defaultSets;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultSets = new DefaultSets();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->defaultSets);
    }

    public function testInvoke(): void
    {
        $config = $this->defaultSets->__invoke();

        foreach ($config as $value) {
            self::assertStringContainsString('Set/', $value);
        }
    }
}
