<?php

	/**
	* @author Pritam Sankhari
	*/

	class ServerList{
		
		var $database;
		var $id;
		var $name;
		var $path;
		var $ip;
		
		function __construct($db){
			$this->database = $db;
		}

		function addServer($name,$path){
			$this->name = $name;
			$this->path = $path;

			$sql = " 

			INSERT INTO 
				servers(name , path) 

			VALUES('$this->name','$this->path')";

			if($result = $this->database->query($sql))
				return true;

			return false;
		}

		function getAll(){

			$sql = "

				SELECT * FROM servers 
			";

			if(!$result = $this->database->query($sql)) return false;

			$servers = array();
			
			if($result->num_rows > 0){

				while($row = $result->fetch_assoc()){
					
					$row['in_use'] = $this->isServerInUse( $row['id'] );
					
					$servers[] = $row;

				}
				return $servers;

			}

			return false;
		}

		function getServerById($id){

			$this->id = $id;
			
			$sql = "

				SELECT * FROM servers WHERE id = $this->id
			";

			if(!$result = $this->database->query($sql)) return false;

			$servers = array();
			
			if($result->num_rows > 0){

				return $result->fetch_assoc();
			}

			return false;
		}

		function isServerInUse($id){

			$this->id = $id;

			$sql = "

				SELECT 
					servers.id,
					scripts.process_id 

				FROM 
					servers 
						JOIN 
					scripts 
						ON 
							servers.id = scripts.destination_id 

				WHERE servers.id = $this->id 

				UNION 

				SELECT 
					servers.id,
					scripts.process_id

				FROM 
					servers 
						JOIN 
					scripts 
						ON 
							servers.id = scripts.source_id
				WHERE servers.id = $this->id

			";

			if(!$result = $this->database->query($sql)) return false;

			$servers = array();
			
			
			
			if($result->num_rows > 0){

				while($row = $result->fetch_assoc()){
					
					$servers[] = $row;

					if( (int)$row['process_id'] > 0) return true;
				}

				return false;

			}

			return false;
		}
		function updateServerById($id,$name,$path){

			$this->id = $id;
			$this->name = $name;
			$this->path = $path;

			$sql = "

				UPDATE 
					servers 
				SET 
					name = '$this->name',
					path = '$this->path'
				WHERE 
					id = $this->id
			";

			if(!$result = $this->database->query($sql)) return false;

			return true;	
		}
		function deleteById($id){

			$this->id = $id;

			$sql = "

				DELETE FROM servers WHERE id = $this->id
			";

			if(!$result = $this->database->query($sql)) return false;

			return true;	
		}
	}
?>