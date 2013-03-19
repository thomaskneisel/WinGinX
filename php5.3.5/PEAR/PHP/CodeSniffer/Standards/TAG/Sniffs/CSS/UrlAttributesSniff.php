<?php
class TAG_Sniffs_CSS_UrlAttributesSniff implements PHP_CodeSniffer_Sniff
{

    public $supportedTokenizers = array('CSS');


    public function register()
    {
        return array(T_STRING);

    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        if (! $phpcsFile->findPrevious(T_STYLE, $stackPtr, null, false, null, true)) {
            return;
        }

        $tokens = $phpcsFile->getTokens();

        $content = $tokens[$stackPtr]['content'];

        if (!(strpos($content, 'url') === 0 && $tokens[$stackPtr+1]['content'] === '(')) {
            return;
        }

        if(strpos($tokens[$stackPtr+2]['content'], '"') !== false || strpos($tokens[$stackPtr+2]['content'], "'") !== false) {
            $error = 'Quotes are not allowed in url()-value';
            $phpcsFile->addError($error, $stackPtr);
        }
    }
}
