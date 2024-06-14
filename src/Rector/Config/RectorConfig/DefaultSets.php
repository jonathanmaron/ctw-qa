<?php
declare(strict_types=1);

namespace Ctw\Qa\Rector\Config\RectorConfig;

use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;

class DefaultSets
{
    public function __invoke(): array
    {
        return [
            LevelSetList::UP_TO_PHP_83,
            PHPUnitSetList::PHPUNIT_100,
            SetList::CODE_QUALITY,
            SetList::CODING_STYLE,
            SetList::DEAD_CODE,
            SetList::NAMING,
        ];
    }
}
