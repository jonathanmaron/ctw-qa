<?php declare(strict_types=1);

namespace CtwTest\Unit\Qa\EasyCodingStandard\Config\ECSConfig;

use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultLineEnding;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;

final class DefaultLineEndingTest extends TestCase
{
    private DefaultLineEnding $defaultLineEnding;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultLineEnding = new DefaultLineEnding();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->defaultLineEnding);
    }

    public function testInvoke(): void
    {
        $config = $this->defaultLineEnding->__invoke();

        assertEquals("\n", $config);
    }
}
