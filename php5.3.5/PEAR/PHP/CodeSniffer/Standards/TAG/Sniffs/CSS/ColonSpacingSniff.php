<?php
class TAG_Sniffs_CSS_ColonSpacingSniff implements PHP_CodeSniffer_Sniff
{

    public $supportedTokenizers = array('CSS');


    public function register()
    {
        return array(T_COLON);

    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $prev = $phpcsFile->findPrevious(PHP_CodeSniffer_Tokens::$emptyTokens, ($stackPtr - 1), null, true);

        if ($tokens[$prev]['code'] !== T_STYLE) {
            // The colon is not part of a style definition.
            return;
        }

        if ($tokens[($stackPtr - 1)]['code'] === T_WHITESPACE) {
            $error = 'There must be no space before a colon in a style definition';
            $phpcsFile->addError($error, $stackPtr, 'Before');
        }

        if ($tokens[($stackPtr + 1)]['code'] !== T_WHITESPACE) {
            $error = 'Expected 1 space after colon in style definition; 0 found';
            $phpcsFile->addError($error, $stackPtr, 'NoneAfter');
        } else {
            $content = $tokens[($stackPtr + 1)]['content'];
            if (strpos($content, $phpcsFile->eolChar) === false) {
                $length  = strlen($content);
                if ($length !== 1) {
                    $error = 'Expected 1 space after colon in style definition; %s found';
                    $data  = array($length);
                    $phpcsFile->addError($error, $stackPtr, 'After', $data);
                }
            } else {
                $error = 'Expected 1 space after colon in style definition; newline found';
                $phpcsFile->addError($error, $stackPtr, 'AfterNewline');
            }
        }

    }

}