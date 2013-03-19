<?php
class Rebuy_Sniffs_CodingConventions_AssignmentTokensSurroundedBySpacesSniff implements PHP_CodeSniffer_Sniff 
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
        return PHP_CodeSniffer_Tokens::$assignmentTokens;
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
        $after  = $tokens[$stackPtr + 1];

        if ($before['type'] != 'T_WHITESPACE') {
            $error = 'Assignment Token "%s" must be preceded by "T_WHITESPACE", got "%s".';
            $error = sprintf($error, $token['type'], $before['type']);
            $phpcsFile->addError($error, $stackPtr, 'Found');
        }

        if ($after['type'] != 'T_WHITESPACE') {
            $error = 'Assignment Token "%s" must be followed by "T_WHITESPACE", got "%s".';
            $error = sprintf($error, $token['type'], $after['type']);
            $phpcsFile->addError($error, $stackPtr, 'Found');
        }

        if ($after['type'] == 'T_WHITESPACE' && 1 < strlen($after['content'])) {
            $error = 'Assignment Token "%s" must be followed by exactly one "T_WHITESPACE", got %d.';
            $error = sprintf($error, $token['type'], strlen($after['content']));
            $phpcsFile->addError($error, $stackPtr, 'Found');
        }
    }
}
