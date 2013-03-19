<?php
//auto-discover the blog settings
require_once 'Services/Blogging.php';

/*
$settings = Services_Blogging::discoverSettings('http://blog.bogo');
var_dump($settings);
echo Services_Blogging::getBestAvailableDriver($settings) . "\r\n";
*/

$bl = Services_Blogging::discoverDriver('http://blog.bogo', 'mylittlename', 's3rgq8cqr32');
var_dump($bl->getRecentPostTitles());
?>