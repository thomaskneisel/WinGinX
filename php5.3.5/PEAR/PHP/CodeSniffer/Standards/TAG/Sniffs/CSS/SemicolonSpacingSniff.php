<?php
class TAG_Sniffs_CSS_SemicolonSpacingSniff implements PHP_CodeSniffer_Sniff
{

    public $supportedTokenizers = array('CSS');


    public function register()
    {
        return array(T_STYLE);

    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $semicolon = $phpcsFile->findNext(T_SEMICOLON, ($stackPtr + 1));
        if ($tokens[($semicolon - 1)]['code'] === T_WHITESPACE) {
            $length  = strlen($tokens[($semicolon - 1)]['content']);
            $error = 'Expected 0 spaces before semicolon in style definition; %s found';
            $data  = array($length);
            $phpcsFile->addError($error, $stackPtr, 'SpaceFound', $data);
        }

    }

}
