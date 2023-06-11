<?php
declare(strict_types=1);

namespace Ctw\Qa\EasyCodingStandard\Config\ECSConfig;

use PHP_CodeSniffer\Standards\Generic\Sniffs\Arrays\DisallowLongArraySyntaxSniff;
use PhpCsFixer\Fixer\ClassNotation\OrderedTraitsFixer;
use PhpCsFixer\Fixer\ControlStructure\TrailingCommaInMultilineFixer;
use PhpCsFixer\Fixer\Import\NoUnusedImportsFixer;
use PhpCsFixer\Fixer\LanguageConstruct\IsNullFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocTypesOrderFixer;
use PhpCsFixer\Fixer\Strict\DeclareStrictTypesFixer;
use PhpCsFixer\Fixer\Strict\StrictComparisonFixer;
use PhpCsFixer\Fixer\Strict\StrictParamFixer;

class DefaultRules
{
    public function __invoke(): array
    {
        return [
            DeclareStrictTypesFixer::class,
            DisallowLongArraySyntaxSniff::class,
            IsNullFixer::class,
            NoUnusedImportsFixer::class,
            OrderedTraitsFixer::class,
            PhpdocTypesOrderFixer::class,
            StrictComparisonFixer::class,
            StrictParamFixer::class,
            TrailingCommaInMultilineFixer::class,
        ];
    }
}
