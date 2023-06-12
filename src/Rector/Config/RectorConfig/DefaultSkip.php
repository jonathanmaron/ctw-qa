<?php
declare(strict_types=1);

namespace Ctw\Qa\Rector\Config\RectorConfig;

use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector;
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
            RenameParamToMatchTypeRector::class,
            RenameVariableToMatchMethodCallReturnTypeRector::class,
            RenameVariableToMatchNewTypeRector::class,
            NewlineAfterStatementRector::class, // on phtml only
        ];
    }
}
