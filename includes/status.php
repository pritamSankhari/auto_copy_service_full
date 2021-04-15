<?php

	function set_status($text,$status=1){
		$_SESSION['msg']['text']=$text;
		$_SESSION['msg']['status_code']=$status;
	}
	

	function show_status(){

		if(isset($_SESSION['msg'])){

			if($_SESSION['msg']['status_code'] == 1){
				echo 
				
				"<div class='status-msg status-msg-success'>".
				
				"<span class='status-msg-text'>".
				$_SESSION['msg']['text'].
				"</span>".

				"<span class='status-msg-close-icon'>".
				
				"<i><svg xmlns= 'http://www.w3.org/2000/svg' width=\"18\" height=\"18\" viewBox=\"0 0 18 18\"><path d=\"M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z\"/></svg></i>".
				"</span>".
				
				"</div>";
			}
			
			else if($_SESSION['msg']['status_code'] == 0){
				echo 
				
				"<div class='status-msg status-msg-error'>".
				
				"<span class='status-msg-text'>".
				$_SESSION['msg']['text'].
				"</span>".

				"<span class='status-msg-close-icon'>".
				
				"<i><svg xmlns= 'http://www.w3.org/2000/svg' width=\"18\" height=\"18\" viewBox=\"0 0 18 18\"><path d=\"M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z\"/></svg>".
				"</span></i>".
				
				"</div>";
			}

			unset($_SESSION['msg']);
		}

	}
?>