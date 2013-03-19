<?php
/**
 * Squiz_Sniffs_CSS_SemicolonSpacingSniff.
 *
 * PHP version 5
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   CVS: $Id: SemicolonSpacingSniff.php 301632 2010-07-28 01:57:56Z squiz $
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */

/**
 * Squiz_Sniffs_CSS_SemicolonSpacingSniff.
 *
 * Ensure each style definition has a semi-colon and it is spaced correctly.
 *
 * @category  PHP
 * @package   PHP_CodeSniffer
 * @author    Greg Sherwood <gsherwood@squiz.net>
 * @copyright 2006 Squiz Pty Ltd (ABN 77 084 670 600)
 * @license   http://matrix.squiz.net/developer/tools/php_cs/licence BSD Licence
 * @version   Release: 1.3.0
 * @link      http://pear.php.net/package/PHP_CodeSniffer
 */
class TAG_Sniffs_CSS_NamingClassesAndStylesSniff implements PHP_CodeSniffer_Sniff
{

    /**
     * A list of tokenizers this sniff supports.
     *
     * @var array
     */
    public $supportedTokenizers = array('CSS');


    /**
     * Returns the token types that this sniff is interested in.
     *
     * @return array(int)
     */
    public function register()
    {
        return array(T_STRING, T_STYLE);

    }//end register()


    /**
     * Processes the tokens that this sniff is interested in.
     *
     * @param PHP_CodeSniffer_File $phpcsFile The file where the token was found.
     * @param int                  $stackPtr  The position in the stack where
     *                                        the token was found.
     *
     * @return void
     */
    public function process(PHP_CodeSniffer_File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        $content = $tokens[$stackPtr]['content'];

        if (strpos($content, '_')) {
            $phpcsFile->addError('Underscore found in %s', $stackPtr, 'UnderscoreFound', array($content));
        }

        if ($tokens[$stackPtr]['code'] === T_STYLE && strtolower($content) !== $content) {
            $phpcsFile->addError('Uppercase letters found in %s, expected %s', $stackPtr, 'UppercaseFound', array($content, strtolower($content)));
        }

        if ($tokens[$stackPtr]['code'] === T_STRING) {
            $inStyleDef = (bool) $phpcsFile->findPrevious(T_STYLE, $stackPtr, null, false, null, true);

            if (!$inStyleDef) {
                 if (strtolower($content) !== $content) {
                    $phpcsFile->addError('Uppercase letters found in %s, expected %s', $stackPtr, 'UppercaseFound', array($content, strtolower($content)));
                 }
            }
        }
    }
}