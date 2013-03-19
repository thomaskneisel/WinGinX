<?php
//http://mylittlename.wordpress.com/
require_once 'Services/Blogging.php';
$bl = Services_Blogging::factory('Blogger', 'mylittlename', 's3rgq8cqr32', 'http://mylittlename.wordpress.com', '/xmlrpc.php');
$bl->setBlogId('mylittlename');



$post = $bl->createNewPost();
//$post->setId('114750983909350416');
$post->content = "This is a test post by Services_Blogging\r\n\r\nSecond line\r\nThird one";

$bl->savePost($post);
echo 'post id: ' . $post->id;

//echo 'delete ' . $bl->deletePost($post);

//var_dump($bl->deletePost('114752812340833006'));



/*
try {
var_dump($bl->getBlogs());
var_dump($bl->getSupportedTemplates());
var_dump($bl->getTemplate('masin'));
} catch (Exception $e) {
    var_dump('Exception: ' . $e->getMessage());
}
*/
?>