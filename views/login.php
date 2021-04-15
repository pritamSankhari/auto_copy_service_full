
<div class="system-heading-block">
	<h1>Auto Copy Service Management System</h1>
</div>

<div class="status-msg-block">
	<?php show_status();?>
</div>

<form style="padding: 10px;/*width: 400px*/background-color: white;" method="post" action="<?= BASE_URL.'do_action.php'?>">
	<div class="login-form-table">
	<table>
		<tr>
			<td>
				<label>User ID:</label>
			</td>
			<td>
				<input type="text" name="user_id">
			</td>
		</tr>

		<tr>
			<td>
				<label>Password:</label>
			</td>
			<td>
				<input type="password" name="user_pwd">
			</td>
		</tr>
		<tr>
			<td>
				<input type="hidden" name="action" value="do_login">
			</td>
		</tr>
		<tr>
			<td>
				<input class="btn btn-add" type="submit" name="" value="Log In">
			</td>
		</tr>
	</table>
	</div>
</form>
