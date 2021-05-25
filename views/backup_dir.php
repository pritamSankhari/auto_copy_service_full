<div class="nav-bar">
	<a class="btn btn-start" href="<?= BASE_URL ?>">Back To Control Panel</a>
	<a class="btn btn-add" href="<?= BASE_URL.'index.php?action=show_servers' ?>">Show all servers</a>
	<a class="btn btn-light-red" href="<?= BASE_URL.'do_action.php?action=do_logout' ?>">Log out</a>
</div>


<div class="status-msg-block">
	<?php show_status();?>
</div>

<form method="post" action="<?= BASE_URL.'do_action.php' ?>">
	<h3>Set Backup Path</h3>
	<div>
	<table>
		<tr>
			<td>
				<label>Script:</label>
			</td>
			<td>
				<select name="script_id">
					<?php foreach ($scripts as $script):?>
						<option value="<?= $script['script_id']?>"><?= $script['script_name'] ?></option>
					<?php endforeach;?>
				</select>
			</td>
		</tr>

		<tr>
			<td>
				<label>Backup Directory Path:</label>
			</td>
			<td>
				<input type="text" name="backup_path">
			</td>
		</tr>
		<tr>
			<td>
				<label>Backup Directory Name:</label>
			</td>
			<td>
				<input type="text" name="backup_dir">
			</td>
		</tr>
		<tr>
			<td>
				<input type="hidden" name="action" value="add_server">
			</td>
		</tr>
		<tr>
			<td>
				<input type="hidden" name="action" value="set_backup_path">
				<input class="btn btn-start" type="submit" name="add" value="Set">
			</td>
		</tr>
	</table>
	</div>
</form>
<?php

	// echo "<pre>";
	// print_r($backups);

?>
<section class="script-list-block">
	
	<?php if($backups):?>
		<h2 style="text-align: center;">Backup info</h2>
		<div>
			<table id="show_servers_table">
				<tr>
					<th>Script Name</th>
					<th>Source Path</th>
					<th>Backup Path</th>
					<th>Script Process</th>
					<th>Backup Process</th>
					
					<!-- <th>Action</th> -->
				</tr>

				<?php foreach($backups as $info):?>
				<tr>
					<td>
						<?= $info['script_name']?>		
					</td>	
					<td>
						<?= $info['source_path']?>		
					</td>
					<td>
						<?= $info['backup_path']?>		
					</td>
					<td>
						<?php if($info['process_id'] == 0 || $info['process_id'] == -1):?>		
							<a href="<?= BASE_URL ?>" class="btn btn-start">Ideal</a>
						<?php else: ?>	
							<a href="<?= BASE_URL ?>" class="btn btn-success">Running ...</a>
						<?php endif;?>	
					</td>
					<td>
						<?php if($info['backup_process_id'] == 0 || $info['backup_process_id'] == -1):?>		
							<a href="<?= BASE_URL ?>" class="btn btn-start">Ideal</a>
						<?php else: ?>	
							<a href="<?= BASE_URL ?>" class="btn btn-success">Running ...</a>
						<?php endif;?>	
					</td>
					
					<td>
						<?php if( $info['backup_process_id'] == 0 || $info['backup_process_id'] == -1):?>
							<a href="<?= BASE_URL.'index.php?action=edit_backup_path&script_id='.$info['script_id'] ?>"><button class="btn-success" onclick="">Edit</button></a>
						<?php endif;?>
						<?php if( $info['backup_process_id'] == 0 || $info['backup_process_id'] == -1):?>
							<a><button class="btn-stop" onclick="confirmDelete(<?php echo $server['id']?>)">Delete</button></a>
						<?php endif;?>	
					</td>
				</tr>
				<?php endforeach;?>
			</table>
		</div>

	<?php else:?>
		<h3>No Backup Path found !</h3>
	<?php endif;?>
</section>