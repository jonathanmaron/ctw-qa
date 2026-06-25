<?php
declare(strict_types=1);

namespace Ctw\Qa\EasyCodingStandard\Config\ECSConfig;

class DefaultLineEnding
{
    /**
     * @return "\n"
     */
    public function __invoke(): string
    {
        return "\n";
    }
}
