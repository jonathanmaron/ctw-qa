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
        /**
         * Common project directories that should be skipped
         */
        $project = ['*/build/*', '*/compiled/*', '*/node_modules/*', '*/vendor/*'];

        /**
         * Rules defined in
         * \Rector\Set\ValueObject\LevelSetList::UP_TO_PHP_81
         * that should be skipped
         */
        $upToPhp81 = [NullToStrictStringFuncCallArgRector::class];

        /**
         * Rules defined in
         * \Rector\PHPUnit\Set\PHPUnitSetList::PHPUNIT_100
         * that should be skipped
         */
        $phpunit100 = [];

        /**
         * Rules defined in
         * \Rector\Set\ValueObject\SetList::CODE_QUALITY
         * that should be skipped
         */
        $codeQuality = [];

        /**
         * Rules defined in
         * \Rector\Set\ValueObject\SetList::CODING_STYLE
         * that should be skipped
         */
        $codingStyle = [
            NewlineAfterStatementRector::class => '*.phtml',
        ];

        /**
         * Rules defined in
         * \Rector\Set\ValueObject\SetList::DEAD_CODE
         * that should be skipped
         */
        $deadCode = [];

        /**
         * Rules defined in
         * \Rector\Set\ValueObject\SetList::NAMING
         * that should be skipped
         */
        $naming = [
            RenameParamToMatchTypeRector::class,
            RenameVariableToMatchMethodCallReturnTypeRector::class,
            RenameVariableToMatchNewTypeRector::class,
        ];

        return [
            ...$project,
            ...$upToPhp81,
            ...$phpunit100,
            ...$codeQuality,
            ...$codingStyle,
            ...$deadCode,
            ...$naming,
        ];
    }
}
