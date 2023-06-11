<?php
declare(strict_types=1);

namespace Ctw\Qa\EasyCodingStandard\Config\ECSConfig;

use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

class DefaultSets
{
    public function __invoke(): array
    {
        return [SetList::CLEAN_CODE, SetList::COMMON, SetList::PSR_12, SetList::STRICT, SetList::SYMPLIFY];
    }
}
