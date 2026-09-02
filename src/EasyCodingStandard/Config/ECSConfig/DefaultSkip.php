<?php
declare(strict_types=1);

namespace Ctw\Qa\EasyCodingStandard\Config\ECSConfig;

use PHP_CodeSniffer\Sniffs\Sniff;
use PhpCsFixer\Fixer\Basic\BracesFixer;
use PhpCsFixer\Fixer\ClassNotation\NoBlankLinesAfterClassOpeningFixer;
use PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer;
use PhpCsFixer\Fixer\FixerInterface;
use PhpCsFixer\Fixer\FunctionNotation\FunctionDeclarationFixer;
use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer;
use PhpCsFixer\Fixer\Whitespace\NoExtraBlankLinesFixer;
use PhpCsFixer\Fixer\Whitespace\StatementIndentationFixer;
use Symplify\CodingStandard\Fixer\Spacing\MethodChainingNewlineFixer;

class DefaultSkip
{
    /**
     * @return array<class-string<FixerInterface|Sniff>|int<0, max>, null|list<string>|string>
     */
    public function __invoke(): array
    {
        /**
         * Common project directories that should be skipped
         */
        $project = ['*/build/*', '*/compiled/*', '*/doc/*', '*/docs/*', '*/node_modules/*', '*/vendor/*'];

        /**
         * Rules defined in SetList::COMMON that should be skipped
         */
        $common = [NotOperatorWithSuccessorSpaceFixer::class];

        /**
         * Rules defined in SetList::PSR_12 that should be skipped
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
         *
         * MethodChainingNewlineFixer breaks a chained call onto its own line,
         * turning "new Temp($id)->createPath()" into two. A short chain reads
         * better on one line, and the fixer offers no length threshold, so it
         * is off. MethodChainingIndentationFixer stays on: it only aligns a
         * chain already written across lines, which is the deliberate case.
         */
        $personal = [
            MethodChainingNewlineFixer::class,
            NoBlankLinesAfterClassOpeningFixer::class,
            NoExtraBlankLinesFixer::class,
        ];

        return [...$project, ...$common, ...$psr12, ...$personal];
    }
}
