<?php
declare(strict_types=1);

namespace Ctw\Qa\EasyCodingStandard\Config\ECSConfig;

class DefaultFileExtensions
{
    /**
     * @return array<string>
     */
    public function __invoke(): array
    {
        return ['php', 'phtml'];
    }
}
