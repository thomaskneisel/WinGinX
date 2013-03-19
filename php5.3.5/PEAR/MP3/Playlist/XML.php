<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 foldmethod=marker: */
/**
 * File contains MP3_Playlist_XML class.
 *
 * PHP version 5
 *
 * LICENSE:
 *
 * The PHP License, version 3.0
 *
 * Copyright (c) 2004-2005 David Costa
 *
 * This source file is subject to version 3.0 of the PHP license,
 * that is bundled with this package in the file LICENSE, and is
 * available through the world-wide-web at the following url:
 * http://www.php.net/license/3_0.txt.
 * If you did not receive a copy of the PHP license and are unable to
 * obtain it through the world-wide-web, please send a note to
 * license@php.net so we can mail you a copy immediately.
 *
 * @category  File_Formats
 * @package   MP3_Playlist
 * @author    David Costa <gurugeek@php.net>
 * @author    Ashley Hewson <morbidness@gmail.com>
 * @author    Firman Wandayandi <firman@php.net>
 * @copyright 2004-2005 David Costa
 * @license   http://www.php.net/license/3_0.txt
 *            The PHP License, version 3.0
 * @version   CVS: $Id: XML.php 272067 2008-12-28 00:22:14Z clockwerx $
 * @link      http://pear.php.net/package/MP3_Playlist
 */

// {{{ Dependencies

/**
 * Load MP3_Playlist_Common as the base class.
 */
require_once 'MP3/Playlist/Common.php';

// }}}
// {{{ Class: MP3_Playlist_XML

/**
 * Class MP3_Playlist_XML, generate the XML document for playlist.
 *
 * @category  File_Formats
 * @package   MP3_Playlist
 * @author    David Costa <gurugeek@php.net>
 * @author    Ashley Hewson <morbidness@gmail.com>
 * @author    Firman Wandayandi <firman@php.net>
 * @copyright 2004-2005 David Costa
 * @license   http://www.php.net/license/3_0.txt
 *            The PHP License, version 3.0
 * @version   Release: 0.5.2
 * @link      http://pear.php.net/package/MP3_Playlist
 */
class MP3_Playlist_XML extends MP3_Playlist_Common
{
    // {{{ Object Properties

    /**
     * Mime type of output.
     * @var string
     */
    protected $mimeType = 'application/xml';

    /**
     * File extension (without dot).
     * @var string
     */
    protected $fileExtension = 'xml';

    /**
     * XML required the merged list.
     * @var bool
     */
    protected $isRequiredMerged = true;

    // }}}
    // {{{ preXML()

    /**
     * Prepares the xml format for the loop used on makexml
     *
     * @param string $value character data that goes into the XML element
     * @param string $key   the name of the XML element
     *
     * @return  TRUE
     */
    private function preXML($value, $key)
    {
        $this->result .= "    <$key>" . htmlentities($value) . "</$key>\n";
        return true;
    }

    // }}}
    // {{{ make()

    /**
     * Generates a valid XML with the playlist values.
     *
     * @param array $params (optional) No parameters, ignore this.
     *
     * @return  bool TRUE
     */
    public function make($params = array())
    {
        // Defining XML headers
        $this->result  = '<?xml version="1.0" encoding="ISO-8859-1" ?>'."\n";
        $this->result .= "<playlist>\n";

        // Adding the prexml formatted tags to each of the array members
        // adding also the track tag
        foreach ($this->merged as $list) {
            $this->result .= "  <track>\n";
            array_walk($list, array(&$this, 'preXML'));
            $this->result .= "  </track>\n";
        }
        $this->result .= "</playlist>";

        return true;
    }

    // }}}
}

// }}}
