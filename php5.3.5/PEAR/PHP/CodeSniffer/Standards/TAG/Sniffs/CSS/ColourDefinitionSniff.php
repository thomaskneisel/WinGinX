<?php
class TAG_Sniffs_CSS_ColourDefinitionSniff implements PHP_CodeSniffer_Sniff
{

    public $supportedTokenizers = array('CSS');

    public function register()
    {
        return array(T_COLOUR);

    }

    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();
        $colour = $tokens[$stackPtr]['content'];

        $expected = strtolower($colour);
        if ($colour !== $expected) {
            $error = 'CSS colours must be defined in lowercase; expected %s but found %s';
            $data  = array(
                      $expected,
                      $colour,
                     );
            $phpcsFile->addError($error, $stackPtr, 'NotUpper', $data);
        }

        // Now check if shorthand can be used.
        if (strpos($colour, '#') === 0 && strlen($colour) < 7) {
            $error    = 'CSS colours must not use shorthand';
            $data     = array(
                         $expected,
                         $colour,
                        );
            $phpcsFile->addError($error, $stackPtr, 'Shorthand', $data);
        }

    }

}

