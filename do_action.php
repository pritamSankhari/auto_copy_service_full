<?php
	
	session_start();
	error_reporting(0);
	require './config/url.php';
	require './config/db.php';
	require './classes/server_list.php';
	require './classes/script_list.php';
	require './classes/general.php';
	require './classes/script_log.php';
	require './classes/backup_model.php';

	require './includes/status.php';
	require './includes/script.php';
	require './includes/auth.php';

	require './vendor/autoload.php';
	use Symfony\Component\Process\Process;
	
	$view = '';

	// -----------------------
	// IF NOT POST REQUEST RECEIVED
	// -----------------------	
	if((!isset($_POST['action']) || empty($_POST)) && is_logged_in()){

		// -----------------------
		// IF PASSING PARAMETER (action) NOT SET
		// -----------------------	
		if(!isset($_GET['action'])){

			header('Location:'.BASE_URL);
			exit();	
		}

		// -----------------------
		// RUN SCRIPT
		// -----------------------		
		if($_GET['action']=='run_script' && isset($_GET['script_id'])){

			$script_id = $db->real_escape_string($_GET['script_id']);
			
			if( !is_valid_script_id( $db , $script_id )) set_status('Invalid Script ID !', 0);

			else if( run_script( $db , $script_id )){

				set_status('Script is running ... ', 1);

				run_backup($db,$script_id);

			} 

			else set_status('Failed to run the script !!! ', 0);
			
			header('Location:'.BASE_URL);	
			exit();
		}

		// -----------------------
		// STOP SCRIPT
		// -----------------------		
		else if($_GET['action']=='stop_script' && isset($_GET['script_id'])){

			$script_id = $db->real_escape_string($_GET['script_id']);

			if(stop_script( $db , $script_id ) ){
				
				set_status('Script has been terminated !', 1);

				stop_backup($db,$script_id);
			}

			header('Location:'.BASE_URL);	
			exit();
		}

		// -----------------------
		// DELETE SCRIPT
		// -----------------------		
		else if($_GET['action']=='delete_script' && isset($_GET['script_id'])){

			$script_id = $db->real_escape_string($_GET['script_id']);

			if( is_script_running( $db , $script_id ) ){
						
				set_status('You can not delete script which is currenly running !', 0);
			}

			else{

				if( delete_script( $db, $script_id ) ){

					$general = new General($db);
					$general->dropTable("script_log_$script_id");
					
					set_status('Script has been deleted successfully !', 1);		
				}
				else{
					set_status('Failed to delete script !', 0);
				}
			}

			header('Location:'.BASE_URL);	
			exit();
		}

		// -----------------------
		// REMOVE SERVER
		// -----------------------		
		else if($_GET['action']=='remove_server' && isset($_GET['server_id'])){

			$server_id = $db->real_escape_string($_GET['server_id']);

			$serverList = new ServerList($db);
			$scriptList = new ScriptList($db);

			if( $serverList->isServerInUse($_GET['server_id']) ){
						
				set_status('This server is in use !!!', 0);
			}

			else{

				if( !$scriptList->deleteScriptWithServer( $server_id ) ){

					set_status('Failed to remove server !', 0);
				}
				
				else if( $serverList->deleteById( $server_id ) ){
					set_status('Server has been removed successfully !', 1);		
				}
				else{
					set_status('Failed to remove server !', 0);
				}
			}

			header('Location:'.BASE_URL.'index.php?action=show_servers');	
			exit();
		}

		// -----------------------
		// REMOVE LOG
		// -----------------------
		else if($_GET['action'] == 'remove_log'){

			if(
				!isset($_GET['script_id']) || empty($_GET['script_id'])
			){

				set_status('Script ID not set !', 0);
				header('Location:'.BASE_URL);
				exit();	
			}

			$script_id = $db->real_escape_string($_GET['script_id']);
			$log_id = $_GET['log_id'];

			$script_log = new ScriptLog($db,$script_id);

			// echo $log_id;
			// exit();
			if(!$script_log->deleteById($log_id)){

				set_status('Failed to delete log !', 0);
				header('Location:'.BASE_URL);
				exit();			
			}

			set_status('Log(s) have been deleted successfully !', 1);
			header('Location:'.BASE_URL);
			exit();

		}

		// -----------------------
		// DO USER LOGOUT
		// -----------------------
		else if($_GET['action']=='do_logout'){

			do_logout();

			header('Location:'.BASE_URL);	
			exit();
		}
	}

	// -----------------------
	// ADD SERVER
	// -----------------------
	else if($_POST['action'] == 'add_server'){

		if(
			!isset($_POST['server_name']) ||
		    !isset($_POST['server_path']) || 
		    empty($_POST['server_name']) || 
		    empty($_POST['server_path'])){
			
			set_status('Server/directory name and server/directory path can not be empty !', 0);
			header('Location:'.BASE_URL);
			exit();
		}

		$server_name = $db->real_escape_string($_POST['server_name']);
		$server_path = $db->real_escape_string($_POST['server_path']);

		$serverList = new ServerList($db);

		
		
		if(!$serverList->addServer($server_name,$server_path)){

			set_status('Failed to add server/directory !', 0);
			header('Location:'.BASE_URL);
			exit();	
		}
		

		set_status('Server/directory added successfully !', 1);
		header('Location:'.BASE_URL);
		exit();	
	}

	// -----------------------
	// UPDATE SERVER
	// -----------------------
	else if($_POST['action'] == 'update_server'){

		if(
			!isset($_POST['server_name']) ||
		    !isset($_POST['server_path']) || 
		    empty($_POST['server_name']) || 
		    empty($_POST['server_path'])){
			
			set_status('Server name and server path can not be empty !', 0);
			header(BASE_URL.'index.php?action=show_servers');
			exit();
		}

		$server_name = $db->real_escape_string($_POST['server_name']);
		$server_path = $db->real_escape_string($_POST['server_path']);

		$serverList = new ServerList($db);

		
		
		if(!$serverList->updateServerById($_POST['server_id'],$server_name,$server_path)){

			set_status('Failed to update server/directory !', 0);
			header('Location:'.BASE_URL);
			exit();	
		}
		

		set_status('Server/directory updated successfully !', 1);
		header('Location:'.BASE_URL);
		exit();	
	}

	// -----------------------
	// SET BACKUP PATH
	// -----------------------
	else if($_POST['action'] == 'set_backup_path'){

		if(
			!isset($_POST['backup_path']) ||
		    !isset($_POST['backup_dir']) || 
		    !isset($_POST['script_id']) || 
		    empty($_POST['backup_path']) || 
		    empty($_POST['backup_dir']) ||
		    empty($_POST['script_id'])
		){
			
			set_status('Path not set !', 0);
			header(BASE_URL.'index.php?action=backup_dir');
			exit();
		}

		$script_id = $_POST['script_id'];
		$backup_dir_path = $db->real_escape_string($_POST['backup_path']);
		$backup_dir_name = $db->real_escape_string($_POST['backup_dir']);

		$backup = new BackupDirs($db);

		if(!$backup->add($backup_dir_name,$backup_dir_path,$script_id)){

			set_status('Backup Path is not set !', 0);
			header('Location:'.BASE_URL);
			exit();		
		}
		

		set_status('Backup Path Added !', 1);
		header('Location:'.BASE_URL);
		exit();	
	}

	// -----------------------
	// UPDATE BACKUP INFO
	// -----------------------
	else if($_POST['action'] == 'update_backup_info'){

		if(
			!isset($_POST['backup_name']) ||
		    !isset($_POST['backup_path']) || 
		    empty($_POST['backup_name']) || 
		    empty($_POST['backup_path'])){
			
			set_status('Backup name and backup path is not set !', 0);
			header(BASE_URL.'index.php?action=backup_dir');
			exit();
		}

		$backup_name = $db->real_escape_string($_POST['backup_name']);
		$backup_path = $db->real_escape_string($_POST['backup_path']);

		$backup = new BackupDirs($db);

		if(!$backup->updateBackupInfo($backup_name,$backup_path,$_POST['script_id'])){

			set_status('Failed to update backup info !', 0);
			header('Location:'.BASE_URL);
			exit();	
		}

		header('Location:'.BASE_URL);
		exit();	
	}

	// -----------------------
	// ADD SCRIPT
	// -----------------------
	else if($_POST['action'] == 'add_script'){

		if(
			!isset($_POST['script_name']) ||
			!isset($_POST['source_id']) || 
			!isset($_POST['destination_id']) || 
			empty($_POST['script_name']) || 
			empty($_POST['source_id']) ||
			empty($_POST['destination_id'])){
			
			set_status('Script is not set !', 0);
			header('Location:'.BASE_URL);
			exit();
		}

		$script_name = $db->real_escape_string($_POST['script_name']);
		$src_id = $db->real_escape_string($_POST['source_id']);
		$dest_id = $db->real_escape_string($_POST['destination_id']);

		if($src_id == "null"){
			set_status('Source path is not set !', 0);
			header('Location:'.BASE_URL);
			exit();				
		}
		if($dest_id == "null"){
			set_status('Destination path is not set !', 0);
			header('Location:'.BASE_URL);
			exit();				
		}

		$general = new General($db);
		$scriptList = new ScriptList($db);

		
		
		if(!$scriptList->addScript($script_name,$src_id,$dest_id)){

			set_status('Failed to add script !', 0);
			header('Location:'.BASE_URL);
			exit();	
		}
		
		$lastId = $scriptList->getLastAddedScriptId();

		// ADD A SCRIPT LOG TABLE
		if(!$general->tableExist("script_log_$lastId")){

			if($scriptList->addScriptLogTable($lastId)){

				set_status('Script added successfully !', 1);
				header('Location:'.BASE_URL);
				exit();			
			}

			set_status('Script added successfully. But failed to created script log table !', 0);
			header('Location:'.BASE_URL);
			exit();			
		}

		set_status('Script added successfully ! Script log table is already exists !', 1);
		header('Location:'.BASE_URL);
		exit();			
		
	}

	// -----------------------
	// UPDATE SCRIPT NAME
	// -----------------------
	else if($_POST['action'] == 'update_script_name'){

		if(
			!isset($_POST['script_name']) ||
			!isset($_POST['script_id']) || 
			
			empty($_POST['script_name']) || 
			empty($_POST['script_id']) ){
			
			set_status('Script ID and Script Name are not set !', 0);
			header('Location:'.BASE_URL);
			exit();
		}

		$script_name = $db->real_escape_string($_POST['script_name']);
		$script_id = $db->real_escape_string($_POST['script_id']);
		$scriptList = new ScriptList($db);

		if($scriptList->updateScriptName($script_id,$script_name)){
			set_status('Script name updated !', 1);
			header('Location:'.BASE_URL);
			exit();
		}

		set_status('Failed to update !', 0);
		header('Location:'.BASE_URL);
		exit();

	}

	// -----------------------
	// INTERCHANGE SCRIPT POSTITION
	// -----------------------
	else if($_POST['action'] == 'interchange_script_position'){

		$scriptList = new ScriptList($db);
		
		if($scriptList->interchangeScriptSerial($_POST['serial_no'])) echo "true";

		else echo "false";
	}

	// -----------------------
	// TOGGLE DAILY BACKUP
	// -----------------------
	else if($_POST['action'] == 'toggle_daily_backup'){

		if(
			!isset($_POST['script_id']) || 
			empty($_POST['script_id'])
		){
			
			set_status('Failed to toggle backup mode !', 0);
			header('Location:'.BASE_URL);
			exit();
		}
		$backup = new BackupDirs($db);
		$daily_backup = $backup->getBackupModeStatus();

		if($daily_backup[$_POST['script_id']] == 1){
			$backup->toggleBackupMode($_POST['script_id'],0);
		}
		else $backup->toggleBackupMode($_POST['script_id'],1);
		
		header('Location:'.BASE_URL);
		exit();
	}
	
	// -----------------------
	// DO IMPORT LOG
	// -----------------------
	else if($_POST['action'] == 'import_log'){

		if(
			!isset($_POST['script_id']) || empty($_POST['script_id'])
		){

			set_status('Script ID not set !', 0);
			header('Location:'.BASE_URL);
			exit();	
		}

		$script_id = $db->real_escape_string($_POST['script_id']);

		if(empty($_FILES['textfile']['name'])){
	    	set_status("No input file has been selected !",0);
	    	header('Location:'.BASE_URL.'index.php?action=import_from_txt');
	    	exit();
	    }
		
		// echo "<pre>";

		// print_r($_FILES);

		// Whether file is uploaded or not
	    if(!is_uploaded_file($_FILES['textfile']['tmp_name'])){
	    	
	    	set_status("File not uploaded !",0);
	    	header('Location:'.BASE_URL.'index.php?action=import_from_txt');
	    	exit();
	    }

	    $filename = $_FILES['textfile']['name'];
	    $fileType = strtolower(pathinfo($filename,PATHINFO_EXTENSION));

	    if($fileType != "txt"){

	    	set_status("Incorrect File Format !",0);
	    	header('Location:'.BASE_URL.'index.php?action=import_from_txt');
	    	exit();
	    }

	    $f = fopen($_FILES['textfile']['tmp_name'], 'r');
	    
	    
	    $script_log = new ScriptLog($db,$script_id);
	    
	    while($data = fgets($f)){
	    	
	    	if(!$script_log->add(trim($data))){

	    		set_status("Failed to add log !",0);
	    		header('Location:'.BASE_URL.'index.php?action=import_from_txt');
	    		exit();		
	    	}

	    }
	   
	    set_status("Logs imported successfully");
		header('Location:'.BASE_URL);	
		exit();
	}

	// -----------------------
	// REMOVE SELECTED LOG(S)
	// -----------------------
	else if($_POST['action'] == 'remove_selected_logs'){

		if(
			!isset($_POST['script_id']) || empty($_POST['script_id'])
		){

			set_status('Script ID not set !', 0);
			header('Location:'.BASE_URL);
			exit();	
		}

		$script_id = $db->real_escape_string($_POST['script_id']);
		$log_id = $_POST['log_id'];

		$script_log = new ScriptLog($db,$script_id);

		$scriptList = new ScriptList($db);
		$source = $scriptList->getSourceByScript($script_id);

		for($i=0;$i<count($log_id);$i++){


			$file = $script_log->getFilenameByID($log_id[$i]);

			try{
				unlink($source['source_path']."\\".$file);	
			}
			catch(Exception $e){

			}
			
			if(!$script_log->deleteByFilename($file)){

				set_status('Failed to delete log !', 0);
				header('Location:'.BASE_URL);
				exit();					
			}
		}

		set_status('Log(s) have been deleted successfully !', 1);
		header('Location:'.BASE_URL);
		exit();

	}

	// REMOVE SELECTED LOG(S) BY DATE
	// -----------------------
	else if($_POST['action'] == 'remove_selected_log_date'){

		if(
			!isset($_POST['script_id']) || empty($_POST['script_id'])
		){

			set_status('Script ID not set !', 0);
			header('Location:'.BASE_URL);
			exit();	
		}

		$script_id = $db->real_escape_string($_POST['script_id']);
		$log_date = $_POST['log_date'];

		$script_log = new ScriptLog($db,$script_id);

		$scriptList = new ScriptList($db);
		$source = $scriptList->getSourceByScript($script_id);

		echo "Removing...";
		for($i=0;$i<count($log_date);$i++){

			$files = $script_log->getFilenamesByDate($log_date[$i]);

			
			for($j = 0;$j < count($files);$j++){

				try{
					unlink($source['source_path']."\\".$files[$j]);	
				}
				catch(Exception $e){

				}
				
				if(!$script_log->deleteByFilename($files[$j])){

					set_status('Failed to delete log !', 0);
					header('Location:'.BASE_URL);
					exit();					
				}
			}
		}

		set_status('Log(s) have been deleted successfully !', 1);
		header('Location:'.BASE_URL);
		exit();

	}



	// -----------------------
	// DO USER LOG IN
	// -----------------------
	else if($_POST['action'] == 'do_login'){

		if(
			!isset($_POST['user_id']) ||
			!isset($_POST['user_pwd']) ||
			empty($_POST['user_id']) ||
			empty($_POST['user_pwd'])
		){

			set_status('User ID and Password can not be empty !', 0);
			header('Location:'.BASE_URL);
			exit();	
		}

		$user_id = $db->real_escape_string($_POST['user_id']);
		$user_pwd = $db->real_escape_string($_POST['user_pwd']);

		if(!do_login($user_id,$user_pwd)){

			set_status('Incorrect User ID or Password  !', 0);
			header('Location:'.BASE_URL);
			exit();	
		}

		header('Location:'.BASE_URL);	
		exit();
	}

	else{
		header('Location:'.BASE_URL);
		exit();
	}


	require $view;

?>