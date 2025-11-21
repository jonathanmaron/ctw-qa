<?php
declare(strict_types=1);

namespace Ctw\Qa\EasyCodingStandard\Config\ECSConfig;

use PhpCsFixer\Fixer\Basic\BracesFixer;
use PhpCsFixer\Fixer\ClassNotation\NoBlankLinesAfterClassOpeningFixer;
use PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionDeclarationFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\Whitespace\NoExtraBlankLinesFixer;
use PhpCsFixer\Fixer\Whitespace\StatementIndentationFixer;

class DefaultSkip
{
    public function __invoke(): array
    {
        /**
         * Common project directories that should be skipped
         */
        $project = ['*/build/*', '*/compiled/*', '*/doc/*', '*/docs/*', '*/node_modules/*', '*/vendor/*'];

        /**
         * Rules defined in
         * \Symplify\EasyCodingStandard\ValueObject\Set\SetList::COMMON
         * that should be skipped
         */
        $common = [NotOperatorWithSuccessorSpaceFixer::class];

        /**
         * Rules defined in
         * \Symplify\EasyCodingStandard\ValueObject\Set\SetList::PSR_12
         * that should be skipped
         */
        $psr12 = [
            BinaryOperatorSpacesFixer::class,
            BlankLineAfterOpeningTagFixer::class,
            BracesFixer::class,
            FunctionDeclarationFixer::class,
            NoTrailingWhitespaceInCommentFixer::class,
            StatementIndentationFixer::class => ['*.phtml'],
        ];

        /**
         * Personal preferences
         */
        $personal = [
            NoBlankLinesAfterClassOpeningFixer::class,
            NoExtraBlankLinesFixer::class,
        ];

        return [...$project, ...$common, ...$psr12, ...$personal];
    }
}
