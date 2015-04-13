<?php
require 'bootstrap.php';

$mode = 'debug'; // 'debug' or 'production'
$server = new RestServer($mode);
// $server->refreshCache(); // uncomment momentarily to clear the cache if classes change in production mode

$server->addClass('UserAccountController', '/users/');

$server->handle();


?>