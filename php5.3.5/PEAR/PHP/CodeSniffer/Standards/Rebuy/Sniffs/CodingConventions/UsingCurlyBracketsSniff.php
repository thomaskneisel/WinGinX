<?php
class Rebuy_Sniffs_CodingConventions_UsingCurlyBracketsSniff implements PHP_CodeSniffer_Sniff 
{
    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return array(int)
     *
     *
     */
    public function register() {
        return array(T_IF, T_FOREACH);
    }

    /**
     * Processes the tokens that this sniff is interested in.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @param int                  $stackPtr  The position in the stack where
     *                                        the token was found.
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr) {
        $tokens = $phpcsFile->getTokens();

        $token = $tokens[$stackPtr];

        $semicolon = $phpcsFile->findNext(array(T_SEMICOLON), $stackPtr);
        $bracket   = $phpcsFile->findNext(array(T_OPEN_CURLY_BRACKET), $stackPtr, $semicolon);
        
        if (false === $bracket) {
            $error = 'Curly brackets missing.';
            $data  = array();
            $phpcsFile->addWarning($error, $stackPtr, 'Found', $data);
        }
    }
}
