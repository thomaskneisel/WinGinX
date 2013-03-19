<?php
class Rebuy_Sniffs_CodingConventions_WhitespaceAfterBooleanNotSniff implements PHP_CodeSniffer_Sniff
{
    public $supportedTokenizers = array('PHP', 'JS', 'CSS');
    
    public function register()
    {
        return array(T_BOOLEAN_NOT);
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
        $after = $tokens[$stackPtr +1 ];

        if ($after['type'] == 'T_WHITESPACE') {
            $phpcsFile->addError('Whitespace not allowed after "!"', $stackPtr);
        }
    }
}
