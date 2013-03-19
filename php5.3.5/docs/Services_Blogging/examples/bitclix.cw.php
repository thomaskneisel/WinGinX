<?php
require_once 'Services/Blogging.php';
$bl = Services_Blogging::factory('metaWeblog', 'mylittlename', 's3rgq8cqr32', 'http://mylittlename.bitclix.com', '/xmlrpc.php');
//$bl->setBlogId('28025532');

var_dump($bl->getRecentPosts());

?>