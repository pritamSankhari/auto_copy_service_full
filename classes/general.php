<?php

	/**
	* @author Pritam Sankhari
	*/

	class General{
		
		var $database;

		function __construct($db){
			$this->database = $db;
		}

		function tableExist($name){

			$sql = "SELECT * FROM information_schema.tables WHERE table_name='$name'";

			if($result = $this->database->query($sql)){

				if($result->num_rows > 0){
					return true;
				}
			}
			return false;

		}

		function dropTable($name){
			
			$sql = "DROP TABLE $name";

			if($this->database->query($sql)){
				return true;
			}
			return false;			
		}
	}
?>
