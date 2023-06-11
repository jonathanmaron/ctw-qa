<?php
declare(strict_types=1);

namespace Ctw\Qa\EasyCodingStandard\Config\ECSConfig;

use PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer;
use PhpCsFixer\Fixer\FunctionNotation\MethodArgumentSpaceFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;

class DefaultRulesWithConfiguration
{
    public function __invoke(): array
    {
        return [
            OrderedImportsFixer::class      => [
                'sort_algorithm' => 'alpha',
                'imports_order'  => ['class', 'function', 'const'],
            ],
            MethodArgumentSpaceFixer::class => [
                'on_multiline' => 'ignore',
            ],
            YodaStyleFixer::class => [
                'equal'            => true,
                'identical'        => true,
                'less_and_greater' => true,
            ],
        ];
    }
}
