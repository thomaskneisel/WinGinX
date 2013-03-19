<?php
class Rebuy_Sniffs_CodingConventions_SemicolonFollowedBySpaceSniff implements PHP_CodeSniffer_Sniff 
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
        return array(T_SEMICOLON);
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
        
        if (false === isset($tokens[$stackPtr + 1])) {
            return;
        }

        $token = $tokens[$stackPtr];
        $after = $tokens[$stackPtr + 1];

        if ($after['type'] != 'T_WHITESPACE') {
            $error = '"%s" must be followed by "T_WHITESPACE", got "%s".';
            $error = sprintf($error, $token['type'], $after['type']);
            $phpcsFile->addError($error, $stackPtr, 'Found');
        }
    }
}
