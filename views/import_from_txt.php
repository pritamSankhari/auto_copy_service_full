<div class="nav-bar">
	<a class="btn btn-start" href="<?= BASE_URL ?>">Back To Control Panel</a>
	<a class="btn btn-add" href="<?= BASE_URL.'index.php?action=show_servers' ?>">Show all servers</a>
	<a class="btn btn-light-red" href="<?= BASE_URL.'do_action.php?action=do_logout' ?>">Log out</a>
</div>

<div class="status-msg-block">
	<?php show_status();?>
</div>

<div class="system-heading-block">
	<h1>Import Logs From text File</h1>
</div>

<form style="padding: 10px;/*width: 400px*/background-color: white;" method="post" action="<?= BASE_URL.'do_action.php'?>" enctype="multipart/form-data">
	<div class="login-form-table">
	<table>
		<tr>
			<td>
				<label>Import To : </label>
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
				<label>From : </label>			
			</td>
			<td>
				<input type="file" name="textfile">
			</td>
		</tr>
		<tr>
			<td>
				<input type="hidden" name="action" value="import_log">
				<input class="btn btn-success" type="submit" name="" value="Import">
			</td>
		</tr>
	</table>
	</div>
</form>
