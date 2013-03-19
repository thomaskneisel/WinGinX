<?php
class Rebuy_Sniffs_CodingConventions_CommaFollowedByWhitespaceSniff implements PHP_CodeSniffer_Sniff 
{
    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return array(int)
     *
     *
     */
    public function register() {
        return array(T_COMMA);
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

        $after  = $tokens[$stackPtr +1];

        if ($after['type'] != 'T_WHITESPACE') {
            $error = 'Expected: T_WHITESPACE, found: ' . $after['type'];
            $data  = array();
            $phpcsFile->addError($error, $stackPtr, 'Found', $data);
        }
    }
}
