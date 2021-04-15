<div class="nav-bar">
	<a class="btn btn-add" href="<?= BASE_URL.'index.php?action=show_servers' ?>">Show all servers</a>
	<a class="btn btn-light-red" href="<?= BASE_URL.'do_action.php?action=do_logout' ?>">Log out</a>
</div>


<div class="status-msg-block">
	<?php show_status();?>
</div>

<form method="post" action="<?= BASE_URL.'do_action.php' ?>">
	<h3 class="add-server-label">Add Server</h3>
	<div class="add-server-form-input-table">
	<table>
		<tr>
			<td>
				<label>Server/Directory Name:</label>
			</td>
			<td>
				<input type="text" name="server_name">
			</td>
		</tr>

		<tr>
			<td>
				<label>Server/Directory Path:</label>
			</td>
			<td>
				<input type="text" name="server_path">
			</td>
		</tr>
		<tr>
			<td>
				<input type="hidden" name="action" value="add_server">
			</td>
		</tr>
		<tr>
			<td>
				<input class="btn btn-add" type="submit" name="add" value="Add">
			</td>
		</tr>
	</table>
	</div>
</form>

<form method="post" action="<?= BASE_URL.'do_action.php' ?>">
	<h3 class="add-script-label">Add Script</h3>
	<div class="add-script-form-input-table">
		<table>
			<tr>
				<td>
					<label>Script Name:</label>
				</td>
				<td>
					<input type="text" name="script_name">
				</td>
			</tr>		

			<tr>
				<td>
					<label>Source Server/Directory:</label>
				</td>
				<td>
					<select name="source_id">
						<option value="null">Not Set</option>
						
						<?php foreach ($servers as $server):?>
						<option value="<?= $server['id']?>"><?= $server['name'] ?></option>
						<?php endforeach;?>

					</select>
				</td>
			</tr>

			<tr>
				<td>
					<label>Destination Server/Directory:</label>
				</td>
				<td>
					<select name="destination_id">
						<option value="null">Not Set</option>

						<?php foreach ($servers as $server):?>
						<option value="<?= $server['id']?>"><?= $server['name'] ?></option>
						<?php endforeach;?>

					</select>
				</td>
			</tr>
			<tr>
				<td>
					<input type="hidden" name="action" value="add_script">
				</td>
			</tr>
			<tr>
				<td>
					<input class="btn btn-add" type="submit" name="add" value="Add">
				</td>
			</tr>
		</table>
	</div>	
</form>

<section class="script-list-block">
	
	<?php if($scripts == true):?>
		<div>
			<table>
				<tr>
					<th>Source Server</th>
					<th>Source Path</th>
					<th>Destination Server</th>
					<th>Destination Path</th>
					<th>Action</th>
				</tr>

				<?php foreach($scripts as $script):?>
				<tr>
					<td>
						<?= $script['source_server']?>		
					</td>	
					<td>
						<?= $script['source_path']?>		
					</td>
					<td>
						<?= $script['destination_server']?>		
					</td>
					<td>
						<?= $script['destination_path']?>		
					</td>
					<td>
						<?php if($script['process_id'] < 1):?>
							<a href="<?= BASE_URL.'do_action.php?action=run_script&script_id='.$script['script_id'] ?>"><button class="btn-start">Start</button></a>
						<?php else:?>
							<a href="<?= BASE_URL.'do_action.php?action=stop_script&script_id='.$script['script_id'] ?>"><button class="btn-stop">Stop</button></a>
						<?php endif;?>
					</td>
					<td>
						<a href="<?= BASE_URL.'do_action.php?action=delete_script&script_id='.$script['script_id'] ?>"><button class="btn-stop">Delete</button></a>
					</td>
				</tr>
				<?php endforeach;?>
			</table>
		</div>

	<?php else:?>
		<h3>No Script found!</h3>
	<?php endif;?>
</section>


<script type="text/javascript">

let addServerFormToggle = true
let addScriptFormToggle = true


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

$('.add-script-label').on('click',function(event){
	
	if(addScriptFormToggle){
		$('.add-script-form-input-table').css({
			
			height:'270px',
			transform:'scaleY(1)',
		})
		addScriptFormToggle=false
	}

	else{
		$('.add-script-form-input-table').css({
			
			height:'0px',
			transform:'scaleY(0)',
		})
		addScriptFormToggle=true
	}
})
</script>