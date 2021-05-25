<?php
	/**
	* @author Pritam Sankhari
	*/

	class ScriptList{

		var $db;
		var $name;
		var $source_id;
		var $destination_id;
		var $process_id;

		function __construct($db){
			$this->database = $db;
		}

		function addScript($name,$src_id,$dest_id){
			$this->name = $name;
			$this->source_id = $src_id;
			$this->destination_id = $dest_id;

			$sql = " 

			INSERT INTO 
				scripts(name , source_id , destination_id) 

			VALUES('$this->name', '$this->source_id' ,'$this->destination_id')";

			if($result = $this->database->query($sql))
				return true;

			return false;
		}

		function getAll(){

			$sql = "

				SELECT * FROM scripts 
			";

			if(!$result = $this->database->query($sql)) return false;

			$scripts = array();
			
			if($result->num_rows > 0){

				while($row = $result->fetch_assoc()){
					$scripts[] = $row;
				}
				return $scripts;

			}

			return false;
		}

		function getScriptById($id){

			$this->id = $id;	
			
			$sql = "

				SELECT * FROM scripts WHERE id = $id
			";

			if(!$result = $this->database->query($sql)) return false;

			$scripts = array();
			
			if($result->num_rows > 0){

				while($row = $result->fetch_assoc()){
					$scripts[] = $row;
				}
				return $scripts;

			}

			return false;
		}

		function updateProcessId($id){
			$this->id = $id;	
			
			$sql = "

				UPDATE scripts SET process_id = 0 WHERE id = $id
			";

			if(!$result = $this->database->query($sql)) return false;

			return true;	
		}

		function getAllInDetail(){
			$sql = "
			SELECT 
				servers.name as destination_server,
    			servers.path as destination_path,
    			scripts1.id as script_id,
    			scripts1.name as script_name,
    			scripts1.process_id,
    			scripts1.source_server,
    			scripts1.source_path
    		FROM 
    			servers 
    			JOIN 
					(SELECT 
				     	scripts.id,
				     	scripts.name,
				     	scripts.process_id,
				     	servers.name as source_server,
				     	servers.path as source_path, 
				     	scripts.destination_id 
				     	
				     	FROM 
				     		scripts 
			     		JOIN 
				     		servers 
			     		ON scripts.source_id=servers.id) 
				as scripts1
			ON servers.id = scripts1.destination_id";

			if(!$result = $this->database->query($sql)) return false;

			$scripts = array();
			
			if($result->num_rows > 0){

				while($row = $result->fetch_assoc()){
					$scripts[] = $row;
				}
				return $scripts;

			}

			return false;
		}

		function deleteScriptWithServer($server_id){

			$this->id = $server_id;

			$sql = "

				DELETE 
				
				FROM 
					scripts
				WHERE 
					source_id = $this->id OR destination_id = $this->id
			";

			if(!$result = $this->database->query($sql)) return false;

			return true;	
		}

		function deleteById($id){

			$this->id = $id;

			$sql = "

				DELETE FROM scripts WHERE id = $this->id
			";

			if(!$result = $this->database->query($sql)) return false;

			return true;	
		}

		function isValidScriptId($id){

			$this->id = $id;	
			
			$sql = "

				SELECT * FROM scripts WHERE id = $id
			";

			if(!$result = $this->database->query($sql)) return false;

			if($result->num_rows > 0) return true;

			return false;
		}

		function getLastAddedScriptId(){

			$sql = "SELECT * FROM scripts ORDER BY id DESC LIMIT 1";

			if($result = $this->database->query($sql)){

				if($result->num_rows > 0){

					$row = $result->fetch_assoc();
					return $row['id'];
				}
			}
			return 0;
		}

		

		function addScriptLogTable($script_id){

			
			$sql = "

				CREATE TABLE script_log_$script_id(

					id varchar(150) PRIMARY KEY,
					copied_file text,
					on_date date,
					at_time time

				)
			";

			// $sql1 = "RENAME TABLE `script_log_30` TO `script_log_31`,`script_log_17` TO `script_log_30`"	
			
			if($this->database->query($sql)) return true;

			return false;
		}


	}
?>