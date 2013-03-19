<?php
class TAG_Sniffs_CSS_SemicolonAtEndOfEachStyleSniff implements PHP_CodeSniffer_Sniff
{

    public $supportedTokenizers = array('CSS');


    public function register()
    {
        return array(T_STYLE);

    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $nextStyle    = $phpcsFile->findNext(T_STYLE, ($stackPtr + 1));
        $semicolon    = $phpcsFile->findNext(T_SEMICOLON, ($stackPtr + 1));
        
        if ($semicolon === false) {
            $error = 'Semicolon at end of definition is missing.';
            $phpcsFile->addError($error, $stackPtr, 'NotAtEnd');
            return;
        }
        
        if ($nextStyle !== false && $tokens[$semicolon]['line'] >= $tokens[$nextStyle]['line']) {
            $error = 'Style definitions must end with a semicolon.';
            $phpcsFile->addError($error, $stackPtr, 'NotAtEnd');
            return;
        }

    }

}
