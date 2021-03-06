<?php
require 'bootstrap.php';
try {
	session_start();
	$session = new Session();
	session_set_save_handler(
		array($session, 'open'),
		array($session, 'close'),
		array($session, 'read'),
		array($session, 'write'),
		array($session, 'destroy'),
		array($session, 'cleanUp')
	);
	$mode = 'debug'; // 'debug' or 'production'
	$server = new RestServer($mode);
	if(isset($_SESSION['app']))
		Core::unserialize($_SESSION['app']);
	$server->refreshCache(); // uncomment momentarily to clear the cache if classes change in production mode
	$server->addClass('UserAccountController', '/users');
	$server->handle();
	$_SESSION['app'] = Core::serialize();
} catch(Exception $ex) {
	var_dump($ex->getMessage());
	var_dump($ex->getTraceAsString());
}

?>