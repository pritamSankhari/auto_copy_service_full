<?php

	/**
	* @author Pritam Sankhari
	*/
	class BackupDirs{

		var $database;

		function __construct($db){

			$this->database = $db;
		}

		function add($dir_name,$dir_path,$script_id){

			$sql = "INSERT INTO backup_dirs(backup_dir_path,backup_dir_name,script_id) VALUES('$dir_path','$dir_name',$script_id)";

			if($this->database->query($sql)) return true;

			return false;
		}

		function getProcessByScript($script_id){

			$sql = "

				SELECT * FROM backup_dirs WHERE script_id = $script_id
			";

			if(!$result = $this->database->query($sql)) return false;

			$scripts = array();
			
			if($result->num_rows > 0){

				
				return $result->fetch_assoc();

			}

			return false;
		}

		function updateProcessId($id){

			$sql = "

				UPDATE backup_dirs SET backup_process_id = 0 WHERE script_id = $id
			";

			if(!$result = $this->database->query($sql)) return false;

			return true;	
		}

		function updateBackupInfo($name,$path,$script_id){

			$sql = "

				UPDATE backup_dirs SET backup_dir_path = '$path' , backup_dir_name = '$name' WHERE script_id = $script_id
			";

			if(!$result = $this->database->query($sql)) return false;

			return true;	
		}

		function getAllInDetail(){
			$sql = "
			SELECT 
				
				backup_dirs.backup_dir_path as backup_path,
				backup_dirs.backup_dir_name as backup_name,
				backup_dirs.backup_process_id,
				backup_dirs.id as id,
    			scripts1.id as script_id,
    			scripts1.name as script_name,
    			scripts1.process_id as process_id,
    			scripts1.source_server as source_server,
    			scripts1.source_path as source_path
    		FROM 
    			backup_dirs 
    			JOIN 
					(SELECT 
				     	scripts.id,
				     	scripts.name,
				     	scripts.process_id,
				     	servers.name as source_server,
				     	servers.path as source_path 
				     	
				     	FROM 
				     		scripts 
			     		JOIN 
				     		servers 
			     		ON scripts.source_id=servers.id) 
				as scripts1
			ON backup_dirs.script_id = scripts1.id";

			if(!$result = $this->database->query($sql)) return false;

			$backup_info = array();
			
			if($result->num_rows > 0){

				while($row = $result->fetch_assoc()){
					$backup_info[] = $row;
				}
				return $backup_info;

			}

			return false;
		}

		function getBackupInfoById($script_id){

			$sql = "SELECT * FROM backup_dirs WHERE script_id = $script_id";

			if(!$result = $this->database->query($sql)) return false;
			
			if($result->num_rows > 0){

				return $result->fetch_assoc();

			}
			return false;

		}

		function getBackupModeStatus(){

			$sql = "SELECT script_id,auto_backup FROM backup_dirs";

			if(!$result = $this->database->query($sql)) return false;

			$backup_info = array();
			
			if($result->num_rows > 0){

				while($row = $result->fetch_assoc()){
					$backup_info[$row['script_id']] = $row['auto_backup'];

				}
				return $backup_info;

			}
		}

		function toggleBackupMode($script_id,$value){

			$sql = "UPDATE backup_dirs SET auto_backup = $value WHERE script_id = $script_id";

			if(!$result = $this->database->query($sql)) return false;

			return true;
		}
	}
?>