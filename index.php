<?php
	
	session_start();
	require './config/url.php';
	require './config/db.php';
	require './classes/server_list.php';
	require './classes/script_list.php';
	require './classes/script_log.php';
	require './classes/backup_model.php';

	require './includes/status.php';
	require './includes/auth.php';
	
	$header = 'views/header.php';
	$view = '';
	$footer = 'views/footer.php';


	$serverList = new ServerList($db);
	$servers = $serverList->getAll();



	if(!is_logged_in()){
		
		$view = 'views/login.php';		
	}

	else if(!isset($_GET) || empty($_GET)){

		$scriptList = new ScriptList($db);
		$scripts = $scriptList->getAllInDetail();


		$backup = new BackupDirs($db);
		$backups_info = $backup->getAllInDetail();
		$daily_backup = $backup->getBackupModeStatus();

		$view = 'views/dashboard.php';
	}


	// -----------------------
	// SHOW ALL SERVERS
	// -----------------------	
	else if(isset($_GET['action']) && $_GET['action'] == 'show_servers'){

		$view = 'views/show_servers.php';
	}

	// -----------------------
	// EDIT SERVER
	// -----------------------	
	else if(isset($_GET['action']) && $_GET['action'] == 'edit_server'){

		if(isset($_GET['server_id']) && !empty($_GET['server_id'])){

			$server = $serverList->getServerById($_GET['server_id']);	
			$view = 'views/edit_server.php';
		}
		else $view = 'views/error_404.php';
	}

	// -----------------------
	// SHOW LOG
	// -----------------------	
	else if(isset($_GET['action']) && $_GET['action'] == 'show_script_log'){
		
		$script_log_table = new ScriptLog($db,$_GET['script_id']);

		$script_logs = $script_log_table->getAll();
		$script_id = $_GET['script_id'];

		$view = 'views/show_logs.php';
	}

	// -----------------------
	// SHOW LOG DATES
	// -----------------------	
	else if(isset($_GET['action']) && $_GET['action'] == 'show_script_log_dates'){
		
		$script_log_table = new ScriptLog($db,$_GET['script_id']);

		$log_dates = $script_log_table->getDates();
		$script_id = $_GET['script_id'];
 		
		$view = 'views/show_log_dates.php';
	}

	// -----------------------
	// IMPORT LOG
	// -----------------------	
	else if(isset($_GET['action']) && $_GET['action'] == 'import_from_txt'){
		
		$scriptList = new ScriptList($db);
		$scripts = $scriptList->getAllInDetail();

		$view = 'views/import_from_txt.php';
	}

	// -----------------------
	// SET BACKUP PATH
	// -----------------------	
	else if(isset($_GET['action']) && $_GET['action'] == 'backup_dir'){
		
		$scriptList = new ScriptList($db);
		$scripts = $scriptList->getAllInDetail();
		$backup = new BackupDirs($db);

		$backups = $backup->getAllInDetail();

		$view = 'views/backup_dir.php';
	}	

	// -----------------------
	// EDIT BACKUP PATH
	// -----------------------	
	else if(isset($_GET['action']) && $_GET['action'] == 'edit_backup_path'){
		
		$scriptList = new ScriptList($db);
		$scripts = $scriptList->getAllInDetail();
		$backup = new BackupDirs($db);

		$backup_info = $backup->getBackupInfoById($_GET['script_id']);

		$view = 'views/edit_backup_path.php';
	}

	else $view = 'views/error_404.php';
	

	require $header;
	require $view;
	require $footer;

