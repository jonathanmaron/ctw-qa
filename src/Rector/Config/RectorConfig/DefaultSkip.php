<?php
declare(strict_types=1);

namespace Ctw\Qa\Rector\Config\RectorConfig;

use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector;

class DefaultSkip
{
    public function __invoke(): array
    {
        /**
         * Common project directories that should be skipped
         */
        $project = ['*/build/*', '*/compiled/*', '*/doc/*', '*/docs/*', '*/node_modules/*', '*/vendor/*'];

        /**
         * Rules defined in LevelSetList::UP_TO_PHP_85 that should be skipped
         */
        $upToPhp85 = [];

        /**
         * Rules defined in PHPUnitSetList::COMPOSER_BASED that should be skipped
         */
        $phpunitComposerBased = [];

        /**
         * Rules defined in SetList::CODE_QUALITY that should be skipped
         */
        $codeQuality = [];

        /**
         * Rules defined in SetList::CODING_STYLE that should be skipped
         */
        $codingStyle = [
            NewlineAfterStatementRector::class => '*.phtml',
        ];

        /**
         * Rules defined in SetList::DEAD_CODE that should be skipped
         */
        $deadCode = [];

        /**
         * Rules defined in SetList::NAMING that should be skipped
         */
        $naming = [
            RenameParamToMatchTypeRector::class,
            RenameVariableToMatchMethodCallReturnTypeRector::class,
            RenameVariableToMatchNewTypeRector::class,
        ];

        return [
            ...$project,
            ...$upToPhp85,
            ...$phpunitComposerBased,
            ...$codeQuality,
            ...$codingStyle,
            ...$deadCode,
            ...$naming,
        ];
    }
}
