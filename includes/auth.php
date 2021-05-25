<?php
	
	function is_logged_in(){

		if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
			return true;
		}

		return false;
	}

	function do_login($user_id,$pwd){

		if($user_id == 'admin'){

			if($pwd == 'admin@123'){

				$_SESSION['user']['id'] = $user_id;

				return true;
			}
		}
		return false;
	}

	function do_logout(){

		unset($_SESSION['user']);
	}

?>