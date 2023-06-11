<?php
declare(strict_types=1);

namespace CtwTest\Unit\Qa\EasyCodingStandard\Config\ECSConfig;

use Ctw\Qa\EasyCodingStandard\Config\ECSConfig\DefaultIndentation;
use PHPUnit\Framework\TestCase;

final class DefaultIndentationTest extends TestCase
{
    private DefaultIndentation $defaultIndentation;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaultIndentation = new DefaultIndentation();
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->defaultIndentation);
    }

    public function testInvoke(): void
    {
        $config = $this->defaultIndentation->__invoke();

        self::assertEquals('spaces', $config);
    }
}
