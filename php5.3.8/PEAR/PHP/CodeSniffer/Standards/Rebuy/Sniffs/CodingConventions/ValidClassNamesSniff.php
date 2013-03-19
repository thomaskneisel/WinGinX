<?php
class Rebuy_Sniffs_CodingConventions_ValidClassNamesSniff implements PHP_CodeSniffer_Sniff 
{
    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return array(int)
     *
     *
     */
    public function register() {
        return array(T_CLASS);
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

        $usingNs = $phpcsFile->findNext(array(T_NAMESPACE), 0, $stackPtr);
        if ($usingNs === false) {
            return;
        }

        if (strpos($token['content'], '_') !== false) {
            $error = 'Using underscores in class names is prohibited.';
            $data  = array();
            $phpcsFile->addWarning($error, $stackPtr, 'Found', $data);
        }
    }
}
