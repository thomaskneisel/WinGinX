<?php
class TAG_Sniffs_CSS_CommaSpacingSniff implements PHP_CodeSniffer_Sniff
{

    public $supportedTokenizers = array('CSS');


    public function register()
    {
        return array(T_COMMA);

    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if ($tokens[ $stackPtr + 1 ]['code'] !== T_WHITESPACE) {
            $error = 'T_WHITESPACE expected after T_COMMA, found ' . $tokens[ $stackPtr + 1 ]['type'];
            $phpcsFile->addError($error, $stackPtr);
        }

        $inStyleDef = (bool) $phpcsFile->findPrevious(T_STYLE, $stackPtr, null, false, null, true);

        if (!$inStyleDef && strpos($tokens[$stackPtr + 1]['content'], "\n") === false) {
            $error = 'Newline expected after T_COMMA, found ' . $tokens[ $stackPtr + 1 ]['type'];
            $phpcsFile->addError($error, $stackPtr);
        }
    }
}