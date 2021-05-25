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
		<h3 class="add-server-label">Edit</h3>
		<div class="add-server-form-input-table">
		<table>
			<tr>
				<td>
					<label>Server/Directory Name:</label>
				</td>
				<td>
					<input type="text" name="server_name" value="<?= $server['name']?>">
				</td>
			</tr>

			<tr>
				<td>
					<label>Server/Directory Path:</label>
				</td>
				<td>
					<input type="text" name="server_path" value="<?= $server['path']?>">
				</td>
			</tr>
			<tr>
				<td>
					<input type="hidden" name="server_id" value="<?= $server['id']?>">
					<input type="hidden" name="action" value="update_server">
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
	let addServerFormToggle = true
	$('.add-server-label').on('click',function(event){
	
		if(addServerFormToggle){
			$('.add-server-form-input-table').css({
				
				
				height:'200px',
				transform:'scaleY(1)',
			})
			addServerFormToggle=false
		}

		else{
			$('.add-server-form-input-table').css({
				
				
				height:'0px',
				transform:'scaleY(0)',
			})
			addServerFormToggle=true
		}
	})

</script>