<?php
declare(strict_types=1);

namespace Ctw\Qa\EasyCodingStandard\Config\ECSConfig;

class DefaultFileExtensions
{
    public function __invoke(): array
    {
        return ['php', 'phtml'];
    }
}
