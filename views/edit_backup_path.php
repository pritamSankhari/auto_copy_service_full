<div class="nav-bar">
	<a class="btn btn-start" href="<?= BASE_URL ?>">Back To Control Panel</a>
	<a class="btn btn-add" href="<?= BASE_URL.'index.php?action=show_servers' ?>">Show all servers</a>
	<a class="btn btn-light-red" href="<?= BASE_URL.'do_action.php?action=do_logout' ?>">Log out</a>
</div>

<div class="status-msg-block">
	<?php show_status();?>
</div>

<section>
	<form method="post" action="<?= BASE_URL.'do_action.php' ?>">
		<h3>Edit</h3>
		<div>
		<table>
			<tr>
				<td>
					<label>Backup Name:</label>
				</td>
				<td>
					<input type="text" name="backup_name" value="<?= $backup_info['backup_dir_name']?>">
				</td>
			</tr>

			<tr>
				<td>
					<label>Server/Directory Path:</label>
				</td>
				<td>
					<input type="text" name="backup_path" value="<?= $backup_info['backup_dir_path']?>">
				</td>
			</tr>
			<tr>
				<td>
					<input type="hidden" name="script_id" value="<?= $backup_info['script_id']?>">
					<input type="hidden" name="action" value="update_backup_info">
				</td>
			</tr>
			<tr>
				<td>
					<input class="btn btn-add" type="submit" name="add" value="Update">
				</td>
			</tr>
		</table>
		</div>
	</form>	
</section>

<script type="text/javascript">
	
</script>