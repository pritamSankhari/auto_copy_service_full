<?php
	$username = 'root';
	$hostserver = 'localhost';
	$database = 'create_copy';
	$password = 'MyPasswordNew';

	$db = new mysqli($hostserver,$username,$password,$database);
	
	if($db->connect_error){
		exit('connection failed');
	}
?>