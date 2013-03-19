<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 foldmethod=marker */

include_once 'include/head.php';
include_once 'include/header.php';

require_once 'Net/URL.php';
$url = new Net_URL;
$url->path = dirname($url->path);

?>
<script language="javascript" type="text/javascript">
function hideElement(id)
{
    var obj = document.getElementById(id);
    if (obj != null) {
        obj.style.display = 'none';
    }
}
function showElement(id)
{
    var obj = document.getElementById(id);
    if (obj != null) {
        obj.style.display = '';
    }
}

function showMakeParams(type)
{
    var makeTypes = new Array('M3U', 'SMIL', 'XML', 'XHTML', 'RSS', 'SQLite');

    showElement('Params' + type);

    for (var i = 0; i < makeTypes.length; i++) {
        if (makeTypes[i] == type) {
            continue;
        }

        hideElement('Params' + makeTypes[i]);
    }
}

function notify(obj, msg)
{
    if (obj != null) {
        obj.style.backgroundColor = '#ADDBAD';
        alert(msg);
    }
}

function validateParams()
{
    var theForm = document.FormParams;

    if (theForm.InputDir.value == '') {
        notify(theForm.InputDir, 'Please type the Input Directory');
        return false;
    }
    if (theForm.BaseURL.value == '') {
        notify(theForm.BaseURL, 'Please type the Base URL');
        return false;
    }
    if (document.getElementById('output_save').checked) {
        if (theForm.OutputDir.value == '') {
            notify(theForm.OutputDir, 'Please type the Output Directory');
            return false;
        }
    }
    if (document.getElementById('output_save').checked ||
        document.getElementById('output_send').checked) {
        if (theForm.FileName.value == '') {
            notify(theForm.FileName, 'Please type the File Name');
            return false;
        }
    }
    if (theForm.MakeType.value == '') {
        notify(theForm.MakeType, 'Please select the Type');
        return false;
    }

    if (theForm.MakeType.value == 'XHTML') {
        if (document.getElementById('ParamsXHTML[title]').value == '') {
            notify(document.getElementById('ParamsXHTML[title]'), 'Please type the Title');
            return false;
        }
    }

    if (theForm.MakeType.value == 'RSS') {
        if (document.getElementById('ParamsRSS[title]').value == '') {
            notify(document.getElementById('ParamsRSS[title]'), 'Please type the Feed Title');
            return false;
        }
        if (document.getElementById('ParamsRSS[description]').value == '') {
            notify(document.getElementById('ParamsRSS[description]'), 'Please type the Feed Description');
            return false;
        }
        if (document.getElementById('ParamsRSS[link]').value == '') {
            notify(document.getElementById('ParamsRSS[link]'), 'Please type the Feed Link');
            return false;
        }
    }

    if (theForm.MakeType.value == 'SQLite') {
        if (document.getElementById('ParamsSQLite[db]').value == '') {
            notify(document.getElementById('ParamsSQLite[db]'), 'Please type the Database Name');
            return false;
        }

        if (document.getElementById('ParamsSQLite[table]').value == '') {
            notify(document.getElementById('ParamsSQLite[table]'), 'Please type the Database Table Name');
            return false;
        }
    }

    return true;
}
</script>
Please specified the parameters, however by default this example assumed that your songs placed in <b><?php print dirname(__FILE__) . DIRECTORY_SEPARATOR . 'songs'; ?></b>.
<h3>Main Parameters</h3>
<form name="FormParams" id="FormParams" action="result.php" target="result" method="post" onSubmit="return validateParams();">
<b>Input Directory:</b><br />
<small>Make sure, this directory readable by Web server.</small><br />
<input type="text" name="InputDir" value="<?php print dirname(__FILE__) . DIRECTORY_SEPARATOR . 'songs'; ?>" size="80" /><br />
<b>Base URL:</b><br />
<small>The base URL where you placed your songs.</small><br />
<input type="text" name="BaseURL" value="<?php print $url->getURL() . '/songs'; ?>" size="80" /><br />
<div id="output_dir" style="display: none">
<b>Output Directory:</b><br />
<input type="text" name="OutputDir" value="<?php print dirname(__FILE__); ?>" size="80" /><br />
</div>
<div id="filename" style="display: ">
<b>File Name:</b><br />
<small>Name of the playlist (without file extension). Suffix is added automatically.</small>
<input type="text" name="FileName" value="test" size="80" /><br />
</div>
<b>Debug:</b><br />
<small>Show debug messages?</small><br />
<input type="radio" name="debug" id="debug_yes" value="1" />
<label for="debug_yes">Yes</label>
<input type="radio" name="debug" id="debug_no" value="0" checked />
<label for="debug_no">No</label>
<h3>Make Parameters</h3>
<b>Make What?</b><br />
<select name="MakeType" onChange="showMakeParams(this.value);">
<option value="">Select ...</option>
<option value="M3U">M3U</option>
<option value="SMIL">SMIL</option>
<option value="XML">XML</option>
<option value="XHTML">XHTML</option>
<option value="RSS">RSS</option>
<option value="SQLite">SQLite</option>
</select><br />
<div id="ParamsXHTML" style="display: none;">
<b>Title (title):</b><br />
<input type="text" name="ParamsXHTML[title]" id="ParamsXHTML[title]" value="Generated Playlist" size="80" /><br />
<b>Fullpage (fullpage):</b><br />
<input type="radio" name="ParamsXHTML[fullpage]" id="ParamsXHTML_fullpage_yes" value="1" checked />
<label for="ParamsXHTML_fullpage_yes">Yes</label>
<input type="radio" name="ParamsXHTML[fullpage]" id="ParamsXHTML_fullpage_no" value="0" />
<label for="ParamsXHTML_fullpage_no">No</label>
</div>
<div id="ParamsRSS" style="display: none;">
<b>Feed Title (title):</b><br />
<input type="text" name="ParamsRSS[title]" id="ParamsRSS[title]" value="Generated Playlist" size="80" /><br />
<b>Feed Description (description):</b><br />
<input type="text" name="ParamsRSS[description]" id="ParamsRSS[description]" value="MP3_Playlist Usage Example" size="80" /><br />
<b>Feed Link (link):</b><br />
<input type="text" name="ParamsRSS[link]" id="ParamsRSS[link]" value="<?php print $url->getURL(); ?>" size="80" /><br />
</div>
<div id="ParamsSQLite" style="display: none;">
<b>Database Name (db):</b><br />
<small>Absolute fullpath also allowed</small><br />
<input type="text" name="ParamsSQLite[db]" id="ParamsSQLite[db]" value="playlist.sqlite" size="80" /><br />
<b>Database Table Name (table):</b><br />
<input type="text" name="ParamsSQLite[table]" id="ParamsSQLite[table]" value="playlist" size="80" /><br />
<b>Create Table (maketable):</b><br />
<input type="radio" name="ParamsSQLite[maketable]" id="ParamsSQLite_maketable_yes" value="1" checked />
<label for="ParamsSQLite_maketable_yes">Yes</label>
<input type="radio" name="ParamsSQLite[maketable]" id="ParamsSQLite_maketable_no" value="0" />
<label for="ParamsSQLite_maketable_no">No</label><br />
<b>Columns (columns):</b><br />
<small>6 columns, separated by commas (fullpath, url, title, artist, album, genre)</small><br />
<input type="text" name="ParamsSQLite[columns]" id="ParamsSQLite[columns]" value="fullpath, url, title, artist, album, genre" size="80" /><br />
</div>
<b>Shuffle:</b><br />
<input type="radio" name="shuffle" id="shuffle_yes" value="1" />
<label for="shuffle_yes">Yes</label>
<input type="radio" name="shuffle" id="shuffle_no" value="0" checked />
<label for="shuffle_no">No</label>
<h3>Output</h3>
<b>Options:</b><br />
<input type="radio" name="output" id="output_save" value="save" onClick="showElement('output_dir'); showElement('filename');" />
<label for="output_save">Save</label>
<input type="radio" name="output" id="output_send" value="send" onClick="hideElement('output_dir'); showElement('filename');" checked />
<label for="output_send">Send</label>
<input type="radio" name="output" id="output_show" value="show" onClick="hideElement('output_dir'); hideElement('filename');" />
<label for="output_show">Show</label><br />
<input type="submit" name="submit" value="Make It!">
</form>
<h3>Result</h3>
<b>Output Result (if available):</b>
<iframe name="result" style="width:100%; height: 400px" frameborder="1"></iframe>
<h3>Source</h3>
<div class="code">
<?php
highlight_file(dirname(__FILE__) . '/result.php');
?>
</div>
<script language="javascript" type="text/javascript">
// Force browser saved form informations.
document.getElementById('output_send').checked = true;
document.FormParams.MakeType.options[0].selected = true;
</script>
<?php
include_once 'include/footer.php';

/*
 * Local variables:
 * mode: php
 * tab-width: 4
 * c-basic-offset: 4
 * c-hanging-comment-ender-p: nil
 * End:
 */
?>
