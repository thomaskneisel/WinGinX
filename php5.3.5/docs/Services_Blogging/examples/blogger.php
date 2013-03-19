<?php

/* Example that adds a post to a blogger.com blog */

/* Include our class */
require_once("Services/RPCBlogging.php");

$api = RPCBlogging::BLOGGER;        // Currently either "Blogger" or "metaWeblog"
$user = "youruserid";       // Put your blog account's username here 
$pass = "yourpassword";     // Put your blog account's password here 

/* The path to the server RPC script. This will
 * usually be specified by your blog software/host.
 * eg) "/api/RPC2" for blogger.com accounts
 */
$path = "/rpc/api.php";

/* The URI of the blog server. Also should provided by the blog software/host
 * that you use.
 * eg) "plant.blogger.com" for blogger.com accounts
 */ 
$address = "host.example.com";

/* Instantiate our class */
$blogger = RPCBlogging::factory($api, $user, $pass, $path, $address);

$myBlogs = $blogger->getBlogs(); // Get an array of our blogs
print_r($myBlogs);               // Note the structure of how the list of blogs is returned

/* Create a new post */
$newPost = new RPCBlogging_Post();

/* The blogger API supports only one field, the content */
$newPost->setContent("This is a test post. Hopefully iy should appear on my
blog, if all goes well!");

/* Actually add the post to the your first blog that is published immediately */
$addPost = $blogger->newPost($myBlogs[0]["blogid"], true, $newPost);
print_r($addPost);              //See that the PostID is returned

/* That's it! Try out the other methods, Have fun! */

?>
