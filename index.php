<?php

date_default_timezone_set('America/Los_Angeles');
$url_prefix = 'http://localhost/noonat';

include 'php/tumblr.php';
$tumblr = new Tumblr('noonat');

ob_start();
$action = isset($_GET['action']) ? $_GET['action'] : null;
if ($action === 'post'):
   $tumblr->read(array('id'=>$_GET['post_id']));
   include 'php/_posts.php';
elseif ($action === 'search'):
   $tumblr->read(array('search'=>$_GET['q']));
   include 'php/_search.php';
else:
   $tumblr->read();
   include 'php/_posts.php';
endif;
$body = ob_get_clean();
include 'php/_layout.php';
