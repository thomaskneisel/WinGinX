<?php
class Rebuy_Sniffs_CodingConventions_TryCatchSniff extends PHP_CodeSniffer_Standards_AbstractPatternSniff
{
    /**
     * Constructs a PEAR_Sniffs_ControlStructures_ControlSignatureSniff.
     */
    public function __construct()
    {
        parent::__construct(true);

    }


    /**
     * Returns the patterns that this test wishes to verify.
     *
     * @return array(string)
     */
    protected function getPatterns()
    {
        return array(
            'try {EOL...} catch (...) {EOL',
        );
    }
}
