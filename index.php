<?php
	
	session_start();
	require './config/url.php';
	require './config/db.php';
	require './classes/server_list.php';
	require './classes/script_list.php';
	require './includes/status.php';
	
	$header = 'views/header.php';
	$view = '';
	$footer = 'views/footer.php';

	$serverList = new ServerList($db);
	$servers = $serverList->getAll();

	if(!isset($_GET) || empty($_GET)){

		

		$scriptList = new ScriptList($db);
		$scripts = $scriptList->getAllInDetail();

		$view = 'views/dashboard.php';
	}


	// -----------------------
	// SHOW ALL SERVERS
	// -----------------------	
	else if(isset($_GET['action']) && $_GET['action'] == 'show_servers'){

		$view = 'views/show_servers.php';
	}

	else $view = 'views/error_404.php';
	

	require $header;
	require $view;
	require $footer;

?>