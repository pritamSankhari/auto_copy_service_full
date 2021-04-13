<?php
	
	session_start();
	require './config/url.php';
	require './config/db.php';
	require './classes/server_list.php';
	require './classes/script_list.php';
	require './includes/status.php';
	require './includes/script.php';

	require './vendor/autoload.php';
	use Symfony\Component\Process\Process;
	
	$view = '';

	// -----------------------
	// IF NOT POST REQUEST RECEIVED
	// -----------------------	
	if(!isset($_POST['action']) || empty($_POST)){

		if(!isset($_GET['action'])){

			header('Location:'.BASE_URL);
			exit();	
		}

		// -----------------------
		// RUN SCRIPT
		// -----------------------		
		if($_GET['action']=='run_script' && isset($_GET['script_id'])){
			
			if( run_script( $db , $_GET['script_id'] ) ) set_status('Script has been started !', 1);
			
			header('Location:'.BASE_URL);	
			exit();
		}

		// -----------------------
		// STOP SCRIPT
		// -----------------------		
		else if($_GET['action']=='stop_script' && isset($_GET['script_id'])){

			if(stop_script( $db , $_GET['script_id'] ) ){
				
				set_status('Script has been terminated !', 1);
			}

			header('Location:'.BASE_URL);	
			exit();
		}

		// -----------------------
		// DELETE SCRIPT
		// -----------------------		
		else if($_GET['action']=='delete_script' && isset($_GET['script_id'])){

			if( is_script_running( $db , $_GET['script_id'] ) ){
						
				set_status('You can not delete script which is currenly running !', 0);
			}

			else{

				if( delete_script( $db, $_GET['script_id'] ) ){
					set_status('Script has been deleted successfully !', 1);		
				}
				else{
					set_status('Failed to delete script !', 0);
				}
			}

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
			
			set_status('Server name or server path can not be empty !', 0);
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

	else{
		header('Location:'.BASE_URL);
		exit();
	}


	require $view;

?>