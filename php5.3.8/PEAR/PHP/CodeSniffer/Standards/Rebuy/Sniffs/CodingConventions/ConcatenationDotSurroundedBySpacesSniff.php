<?php
class Rebuy_Sniffs_CodingConventions_ConcatenationDotSurroundedBySpacesSniff implements PHP_CodeSniffer_Sniff 
{
    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return array(int)
     *
     *
     */
    public function register() {
        return array(T_STRING_CONCAT);
    }

    /**
     * Processes the tokens that this sniff is interested in.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @param int                  $stackPtr  The position in the stack where
     *                                        the token was found.
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $token = $tokens[$stackPtr];
        $before = $tokens[$stackPtr - 1];
        $after = $tokens[$stackPtr + 1];

        if ($before['type'] != 'T_WHITESPACE') {
            $error = 'String concatenation operator "%s" must be preceded by "T_WHITESPACE", got "%s".';
            $error = sprintf($error, $token['type'], $before['type']);
            $data  = array();
            $phpcsFile->addError($error, $stackPtr, 'Found', $data);
        }
        
        if ($after['code'] == T_EQUAL || 
            $after['content'] == "\r" ||
            $after['content'] == "\n"
        ) {
            return;
        }
        
        if ($after['type'] != 'T_WHITESPACE' && $after['type'] != PHP_EOL) {
            $error = 'String concatenation operator "%s" must be followed by "T_WHITESPACE", got "%s".';
            $error = sprintf($error, $token['type'], $after['type']);
            $data  = array();
            $phpcsFile->addError($error, $stackPtr, 'Found', $data);
        }
    }
}
