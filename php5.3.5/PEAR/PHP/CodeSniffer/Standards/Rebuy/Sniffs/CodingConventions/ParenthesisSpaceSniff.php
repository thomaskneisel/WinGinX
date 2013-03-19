<?php
class Rebuy_Sniffs_CodingConventions_ParenthesisSpaceSniff implements PHP_CodeSniffer_Sniff 
{
    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return array(int)
     *
     *
     */
    public function register()
    {
        return array(T_OPEN_PARENTHESIS, T_CLOSE_PARENTHESIS);
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
        $token  = $tokens[$stackPtr];
        $before = $tokens[$stackPtr - 1];
        $after  = $tokens[$stackPtr + 1];

        if ($token['type'] == 'T_OPEN_PARENTHESIS' &&
            $after['type'] == 'T_WHITESPACE' &&
            $after['content'] != "\r" &&
            $after['content'] != "\n")
        {
            $error = '"T_WHITESPACE" not allowed after an opening parenthesis.';
            $phpcsFile->addError($error, $stackPtr, 'Found');
        }
        
        if ($token['type'] == 'T_CLOSE_PARENTHESIS' &&
            $before['type'] == 'T_WHITESPACE' &&
            $before['content'] != "\r" &&
            $before['content'] != "\n" && 
            $tokens[$stackPtr - 2]['type'] != 'T_COMMENT' &&
            $tokens[$stackPtr - 2]['content'] != "\r" &&
            $tokens[$stackPtr - 2]['content'] != "\n")
        {
            $error = '"T_WHITESPACE" not allowed before a closing parenthesis.';
            $phpcsFile->addError($error, $stackPtr, 'Found');
        }
    }
}
