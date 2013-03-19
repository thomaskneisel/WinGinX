<?php
class Rebuy_Sniffs_CodingConventions_ArithmeticTokensSurroundedBySpacesSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * List of Tokens that require a Whitespace after the arithmic operator
     *
     * @var array
     */
    private $requireWhitespace = array(
        'T_STRING',
        'T_VARIABLE',
        'T_DNUMBER',
        'T_LNUMBER',
        'T_CLOSE_PARENTHESIS',
        'T_CLOSE_SQUARE_BRACKET',
        'T_WHITESPACE',
        'T_INC',
    );

    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return array(int)
     */
    public function register()
    {
        return PHP_CodeSniffer_Tokens::$arithmeticTokens;
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

        if ($before['type'] == 'T_OPEN_PARENTHESIS') {
            return;
        }

        // whitespace before operator allways required
        if ($before['type'] != 'T_WHITESPACE') {
            $error = 'Arithmetic Token "%s" must be preceded by "T_WHITESPACE", got "%s".';
            $error = sprintf($error, $token['type'], $before['type']);
            $phpcsFile->addError($error, $stackPtr, 'Found');
        }

        // token context requires a whitespace after the operator
        if ($this->whitespaceAfterTokenRequired($tokens[$stackPtr - 2]['type'])
            && $after['type'] != 'T_WHITESPACE'
        ) {
            $error = 'Arithmetic Token "%s" must be followed by "T_WHITESPACE", got "%s".';
            $error = sprintf($error, $token['type'], $after['type']);
            $phpcsFile->addError($error, $stackPtr, 'Found');
        }
        
        // token context forbids a whitespace after the operator
        if (false === $this->whitespaceAfterTokenRequired($tokens[$stackPtr - 2]['type'])
            && $after['type'] == 'T_WHITESPACE'
        ) {
            $error = 'Arithmetic Token "%s" must not be followed by "T_WHITESPACE".';
            $error = sprintf($error, $token['type']);
            $phpcsFile->addError($error, $stackPtr, 'Found');
        }

        // only one whitespace token after the operator allowed
        if ($after['type'] == 'T_WHITESPACE' && 1 < strlen($after['content'])) {
            $error = 'Arithmetic Token "%s" must be followed by exactly one "T_WHITESPACE", got %d.';
            $error = sprintf($error, $token['type'], strlen($after['content']));
            $phpcsFile->addError($error, $stackPtr, 'Found');
        }
    }
    
    /**
     * @var string $type
     * @return bool
     */
    protected function whitespaceAfterTokenRequired($type)
    {
        return in_array($type, $this->requireWhitespace);
    }
}
