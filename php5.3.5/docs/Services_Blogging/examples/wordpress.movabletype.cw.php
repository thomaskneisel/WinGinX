<?php
/*
dummytest@mailinator.com
mylittlename
s3rgq8cqr32
API key: c7eb231e4dfd
*/

//http://mylittlename.wordpress.com/
require_once 'Services/Blogging.php';
//$bl = Services_Blogging::factory('metaWeblog', 'mylittlename', 's3rgq8cqr32', 'http://mylittlename.wordpress.com', '/xmlrpc.php');
$bl = Services_Blogging::factory('MovableType', 'mylittlename', 's3rgq8cqr32', 'http://blog.bogo', '/xmlrpc.php');



$post = $bl->createNewPost();
//$post->setId('14');
$post->title = 'Modified post title';
$post->content = "This is a modified test post by Services_Blogging\r\n\r\nSecond line\r\nThird one";
$post->categories = array('cat1', 'cat3');

$bl->savePost($post);
$nLastPostId = $post->id;
echo 'post id: ' . $post->id . "\r\n";


//$bl->deletePost(17);

var_dump($bl->getPost($nLastPostId));
var_dump($bl->getRecentPostTitles(2));
var_dump($bl->getRecentPosts());

?>