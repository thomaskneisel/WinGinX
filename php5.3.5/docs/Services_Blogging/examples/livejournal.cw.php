<?php
//http://mylittlename.livejournal.com/
require_once 'Services/Blogging.php';
$bl = Services_Blogging::factory('LiveJournal', 'mylittlename', 's3rgq8cqr32', null, null);


/*
$post = $bl->createNewPost();
$post->title = 'Testtitle';
$post->content = "This is a test post by Services_Blogging\r\nSecond line\r\nThird one";

$bl->savePost($post);
echo 'post id: ' . $post->id . "\r\n";


$post->content = 'And this is a changed one';
$bl->savePost($post);
*/
/*
$post = $bl->getPost(-1);
var_dump($post);
/*
echo date('Y-m-d H:i:s', $post->date) . "\r\n";
*/


var_dump($bl->getRecentPostTitles());
?>