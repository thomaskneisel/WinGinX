<?php
class Rebuy_Sniffs_CodingConventions_ValidBooleanAndNullValuesSniff implements PHP_CodeSniffer_Sniff 
{
    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return array(int)
     *
     *
     */
    public function register() {
        return array(T_TRUE, T_FALSE, T_NULL);
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

        if ($token['content'] !== strtolower($token['content'])) {
            $error = 'NULL and boolean values have to be lowercase.';
            $data  = array();
            $phpcsFile->addError($error, $stackPtr, 'Found', $data);
        }
    }
}
