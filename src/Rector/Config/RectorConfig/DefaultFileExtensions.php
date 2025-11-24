<?php
declare(strict_types=1);

namespace Ctw\Qa\Rector\Config\RectorConfig;

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
