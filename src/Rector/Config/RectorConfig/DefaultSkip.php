<?php
declare(strict_types=1);

namespace Ctw\Qa\Rector\Config\RectorConfig;

use Rector\Php81\Rector\FuncCall\NullToStrictStringFuncCallArgRector;

class DefaultSkip
{
    public function __invoke(): array
    {
        return [
            '*/build/*',
            '*/compiled/*',
            '*/node_modules/*',
            '*/vendor/*',
            NullToStrictStringFuncCallArgRector::class,
        ];
    }
}
