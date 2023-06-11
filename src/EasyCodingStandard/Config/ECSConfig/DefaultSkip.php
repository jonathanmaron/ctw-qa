<?php
declare(strict_types=1);

namespace Ctw\Qa\EasyCodingStandard\Config\ECSConfig;

use PhpCsFixer\Fixer\Basic\BracesFixer;
use PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer;
use PhpCsFixer\Fixer\FunctionNotation\FunctionDeclarationFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\Whitespace\StatementIndentationFixer;

class DefaultSkip
{
    public function __invoke(): array
    {
        return [
            '*/build/*',
            '*/compiled/*',
            '*/node_modules/*',
            '*/vendor/*',
            BinaryOperatorSpacesFixer::class,
            BlankLineAfterOpeningTagFixer::class,
            BracesFixer::class,
            FunctionDeclarationFixer::class,
            NoTrailingWhitespaceInCommentFixer::class,
            StatementIndentationFixer::class,  // disable in phtml only
            NotOperatorWithSuccessorSpaceFixer::class,
        ];
    }
}
