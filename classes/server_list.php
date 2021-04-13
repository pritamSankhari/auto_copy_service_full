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
					$servers[] = $row;
				}
				return $servers;

			}

			return false;
		}
	}
?>