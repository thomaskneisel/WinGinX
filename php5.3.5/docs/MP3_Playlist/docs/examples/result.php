<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 foldmethod=marker */

/**
 * Load MP3_Playlist class.
 */
require_once 'MP3/Playlist.php';

if (isset($_POST['submit'])) {
    // Default make parameters
    $params = array();

    // Pick the type.
    switch ($_POST['MakeType']) {
        case 'M3U':
            $type = MP3_Playlist::TYPE_M3U;
            break;
        case 'SMIL':
            $type = MP3_Playlist::TYPE_SMIL;
            break;
        case 'XML':
            $type = MP3_Playlist::TYPE_XML;
            break;
        case 'XHTML':
            $type = MP3_Playlist::TYPE_XHTML;
            $params = $_POST['ParamsXHTML'];
            break;
        case 'RSS':
            $type = MP3_Playlist::TYPE_RSS;
            $params = $_POST['ParamsRSS'];
            break;
        case 'SQLite':
            $type = MP3_Playlist::TYPE_SQLITE;
            $params = $_POST['ParamsSQLite'];
            break;
    }

    // Create new instance of MP3_Playlist.
    $playlist = new MP3_Playlist($_POST['InputDir'], $_POST['OutputDir'],
                                 $_POST['BaseURL'], $_POST['debug']);

    try {
        // Call make() method, where 3 parameters (type, params and shuffle).
        $playlist->make($type, $params, $_POST['shuffle']);

        $outputFunction = $_POST['output'] . '()';

        // Decoration.
        if ($_POST['output'] == 'show') {
            print "<pre>\n";
        }

        // Call output method.
        $playlist->$_POST['output']($_POST['FileName']);

        // Decoration.
        if ($_POST['output'] == 'show') {
            print "</pre>\n";
        }
    } catch (PEAR_Exception $e) {
        print '<b>Error</b>: ' . $e->getMessage();
    }
}

/*
 * Local variables:
 * mode: php
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
?>
