<?php
	$username = 'root';
	$hostserver = 'localhost';
	$database = 'acs';
	$password = '';

	$db = new mysqli($hostserver,$username,$password,$database);
	
	if($db->connect_error){
		exit('connection failed');
	}
?>