<?php
class Rebuy_Sniffs_CodingConventions_WhitespacesBeforeLineendsSniff implements PHP_CodeSniffer_Sniff
{
    public $supportedTokenizers = array('PHP', 'JS', 'CSS');
    
    public function register()
    {
        return array(T_WHITESPACE);
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

        if (preg_match("/\s+\n/", $token['content'])) {
            $phpcsFile->addError('Whitespace found before line end.', $stackPtr);
        }
    }
}
