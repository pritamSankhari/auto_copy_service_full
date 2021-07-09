<?php
	use Symfony\Component\Process\Process;

	function run_script($db,$id){
		
		$script = new Process(['tools/acsv2',$id]);
		$script->start();

		$scriptList = new ScriptList($db);

		if(!$scripts = $scriptList->getScriptById($id)) return false;
		$process_id = (int) $scripts['process_id'];

		while($process_id < 1){

			if(!$scripts = $scriptList->getScriptById($id)) return false;
			$process_id = (int) $scripts['process_id'];	

			if( $process_id < 0 ) return false;
			
		}
		
		return true;
	}

	function run_backup($db,$script_id){
		
		$backup = new BackupDirs($db);

		// if backup for this script not exists
		if(!$backup_process = $backup->getProcessByScript($script_id)) return false;

		$daily_backup = $backup->getBackupModeStatus();

		if($daily_backup[$script_id] == 0) return false;

		$script = new Process(['tools/b',$script_id]);
		$script->start();

		
		if(!$backup_process = $backup->getProcessByScript($script_id)) return false;
		$process_id = (int) $backup_process['backup_process_id'];

		while($process_id < 1){

			if(!$backup_process = $backup->getProcessByScript($script_id)) return false;
			
			$process_id = (int) $backup_process['backup_process_id'];

			if( $process_id < 0 ) return false;
		}
		
		return true;
	}

	function stop_script($db,$id){

		$scriptList = new ScriptList($db);

		if(!$scripts = $scriptList->getScriptById($id)) return false;

		$process_id = $scripts['process_id'];

		exec("kill -9 $process_id");
		
		if($scriptList->updateProcessId($id)) return true;

		return false;
	}

	function stop_backup($db,$id){

		$backup = new BackupDirs($db);

		if(!$backup_process = $backup->getProcessByScript($id)) return false;

		$process_id = $backup_process['backup_process_id'];


		exec("taskkill /F /PID $process_id");
		
		if($backup->updateProcessId($id)) return true;

		return false;
	}

	function delete_script($db,$id){

		$scriptList = new ScriptList($db);

		if(!$scripts = $scriptList->deleteById($id)) return false;

		return true;
	}

	function is_script_running($db,$id){

		$scriptList = new ScriptList($db);

		if(!$scripts = $scriptList->getScriptById($id)) return false;
		
		$process_id = (int) $scripts[0]['process_id'];

		if($process_id < 1) return false;

		return true;
	}

	function is_valid_script_id($db,$id){
		
		$scriptList = new ScriptList($db);		

		if( $scriptList->isValidScriptId( $id ) ) return true;

		return false;
	}

?>