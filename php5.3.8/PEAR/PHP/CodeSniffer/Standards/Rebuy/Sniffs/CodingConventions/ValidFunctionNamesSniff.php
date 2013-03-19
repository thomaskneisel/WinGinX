<?php
class Rebuy_Sniffs_CodingConventions_ValidFunctionNamesSniff implements PHP_CodeSniffer_Sniff
{

    private $interceptors = array(
      '__construct',
      '__destruct',
      '__call',
      '__callStatic',
      '__get',
      '__set',
      '__isset',
      '__unset',
      '__sleep',
      '__wakeup',
      '__toString',
      '__invoke',
      '__set_state',
      '__clone'
    );

    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return array(int)
     *
     *
     */
    public function register() {
        return array(T_FUNCTION);
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

        $token = $tokens[$stackPtr + 2];
        $after = $tokens[$stackPtr + 3];

        if (in_array($token['content'], $this->interceptors)) {
            return;
        }

        if (strpos($token['content'], '_') !== false) {
            $error = 'Method "%s" must not contain a underscore even if declared non-public.';
            $data  = array($token['content']);
            $phpcsFile->addError($error, $stackPtr, 'underscore', $data);
        }

        if ($after['type'] == 'T_WHITESPACE') {
            $error = 'Method "%s" must not contain a T_WHITESPACE after its name.';
            $data  = array($token['content']);
            $phpcsFile->addError($error, $stackPtr, 'whitespace', $data);
        }
    }
}
