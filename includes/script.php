<?php
	use Symfony\Component\Process\Process;

	function run_script($db,$id){
		
		$script = new Process(['start','acs_main',$id]);
		$script->start();

		$scriptList = new ScriptList($db);

		if(!$scripts = $scriptList->getScriptById($id)) return false;
		$process_id = (int) $scripts[0]['process_id'];

		while($process_id < 1){

			if(!$scripts = $scriptList->getScriptById($id)) return false;
			$process_id = (int) $scripts[0]['process_id'];	
		}
		
		return true;
	}

	function stop_script($db,$id){

		$scriptList = new ScriptList($db);

		if(!$scripts = $scriptList->getScriptById($id)) return false;

		$process_id = $scripts[0]['process_id'];

		exec("taskkill /F /PID $process_id");
		
		if($scriptList->updateProcessId($id)) return true;

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

?>