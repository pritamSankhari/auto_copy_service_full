<?php
	
	session_start();
	require './config/url.php';
	require './config/db.php';
	require './classes/server_list.php';
	require './classes/script_list.php';
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

			else if( run_script( $db , $script_id )) set_status('Script is running ... ', 1);

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
			
			set_status('Server name and server path can not be empty !', 0);
			header('Location:'.BASE_URL);
			exit();
		}

		$server_name = $db->real_escape_string($_POST['server_name']);
		$server_path = $db->real_escape_string($_POST['server_path']);

		$serverList = new ServerList($db);

		
		
		if(!$serverList->addServer($server_name,$server_path)){

			set_status('Failed to add server !', 0);
			header('Location:'.BASE_URL);
			exit();	
		}
		

		set_status('Server added successfully !', 1);
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

		$scriptList = new ScriptList($db);

		
		
		if(!$scriptList->addScript($script_name,$src_id,$dest_id)){

			set_status('Failed to add script !', 0);
			header('Location:'.BASE_URL);
			exit();	
		}
		

		set_status('Script added successfully !', 1);
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