<div class="nav-bar">
	<a class="btn btn-start" href="<?= BASE_URL ?>">Back To Control Panel</a>
	<a class="btn btn-add" href="<?= BASE_URL.'index.php?action=show_servers' ?>">Show all servers</a>
	<a class="btn btn-light-red" href="<?= BASE_URL.'do_action.php?action=do_logout' ?>">Log out</a>
</div>

<div class="status-msg-block">
	<?php show_status();?>
</div>

<div>
	<div>
		<form method="post" action="<?= BASE_URL.'do_action.php'?>">
			<input type="text" name="script_name" value="<?= $script['name']?>">

			<input type="hidden" name="script_id" value="<?= $script['id']?>">	
			<input type="hidden" name="action" value="update_script_name">
			<input class="btn btn-success" type="submit" name="" value="Save">
		</form>
	</div>
</div>