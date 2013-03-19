<?php
class TAG_Sniffs_CSS_CurlyBracketsSniff implements PHP_CodeSniffer_Sniff
{

    public $supportedTokenizers = array('CSS');


    public function register()
    {
        return array(T_OPEN_CURLY_BRACKET, T_CLOSE_CURLY_BRACKET);

    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        //remove close tag from the end
        $count = count($tokens);
        if ($tokens[ $count - 1 ]['code'] === T_CLOSE_TAG) {
            unset($tokens[ $count - 2 ]);
            unset($tokens[ $count - 1 ]);
        }

        $before = (strpos($tokens[$stackPtr - 1]['content'], "\n") !== false);
        $after = (!isset($tokens[$stackPtr + 1]) || (strpos($tokens[$stackPtr + 1]['content'], "\n") !== false));

        if (!($before && $after)) {
            $error = $tokens[$stackPtr]['type'] . ' must have its own line.';
            $phpcsFile->addError($error, $stackPtr);
            return;
        }
    }

}
