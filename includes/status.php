<?php

	function set_status($text,$status=1){
		$_SESSION['msg']['text']=$text;
		$_SESSION['msg']['status_code']=$status;
	}
	

	function show_status(){

		if(isset($_SESSION['msg'])){

			if($_SESSION['msg']['status_code'] == 1){
				echo "<div class='status-msg status-msg-success'>".$_SESSION['msg']['text']."</div>";
			}
			
			else if($_SESSION['msg']['status_code'] == 0){
				echo "<div class='status-msg status-msg-error'>".$_SESSION['msg']['text']."</div>";
			}

			unset($_SESSION['msg']);
		}

	}
?>