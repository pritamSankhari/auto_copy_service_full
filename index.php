<?php
	
	session_start();
	require './config/url.php';
	require './config/db.php';
	require './classes/server_list.php';
	require './classes/script_list.php';
	require './includes/status.php';
	
	$view = '';

	if(!isset($_GET) || empty($_GET)){

		$serverList = new ServerList($db);
		$servers = $serverList->getAll();

		$scriptList = new ScriptList($db);
		$scripts = $scriptList->getAllInDetail();

		$view = 'views/dashboard.php';
	}
	// echo "hello";
	require $view;

?>