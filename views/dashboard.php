<!DOCTYPE html>
<html>
<head>
	<title></title>
	<script type="text/javascript" src="<?= BASE_URL.'assets/js/jquery.js' ?>"></script>
	<style type="text/css">
		form{
			margin:10px;
			/*margin-bottom: 20px;*/
			font-family: consolas;
			font-size:18px;
			background-color: lightgrey;

		}
		form h3{
			background-color: black;
			color: white;
			font-variant-caps:small-caps;
			font-size: 24px;
			padding: 10px;
			font-family: sans-serif;
			user-select: none;
			cursor: pointer;
			/*margin: 10px;*/
		}
		form table{
			padding: 10px;
			transition: 2s;
		}
		input,label,select{
			user-select: none;
			margin:10px;
			font-family: consolas;
			font-size:18px;
			border:none;
			padding: 5px;
			border-radius: 5px;
		}
		input[type=text],select{
			/*border: 2px solid grey;*/
		}
		input[type=submit]{
			background-color: slateblue;
			color: white;
			border: none;

			font-variant-caps:small-caps;
			width: 100px;
			padding: 5px;
		}
		input[type=submit]:hover{
			background-color: darkslateblue;
			cursor: pointer;
		}
		button{
			
			cursor: pointer;
			width: 60px;
			padding: 5px;
			border: none;
			border-radius: 4px;
		}
		button.btn-start{
			background-color: dodgerblue;
			color: white;
		}
		button.btn-stop{
			background-color: tomato;
			color: white;	
		}
		.add-server-form-input-table{
			transition: 2s;
			display: none;
		}
		.add-script-form-input-table{
			transition: 2s;
			display: none;
		}
		.status-msg{
			margin:10px;
			padding: 15px;
			font-family: consolas;
			font-variant-caps: small-caps;
		}
		.status-msg-success{
			color:white;
			background-color: seagreen;
		}
		.status-msg-error{
			color:white;
			background-color: sienna;
		}

		.script-list-block{
			font-family:tahoma;
			font-variant-caps: small-caps;
			margin:10px;
			margin-top: 30px;
		}
		.script-list-block table{
			background-color: lightgrey;
			width: 100%;
			text-align: center;
		}
		.script-list-block table td{
			padding: 20px;
		}
		/*.script-list-block table{}*/
	</style>
</head>
<body>

	<div class="content">
		<div class="status-msg-block">
			<?php show_status();?>
		</div>

		<form method="post" action="<?= BASE_URL.'do_action.php' ?>">
			<h3 class="add-server-label">Add Server</h3>
			<table class="add-server-form-input-table">
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
						<input type="submit" name="add" value="Add">
					</td>
				</tr>
			</table>
		</form>

		<form method="post" action="<?= BASE_URL.'do_action.php' ?>">
			<h3 class="add-script-label">Add Script</h3>
			<table class="add-script-form-input-table">
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
					<input type="submit" name="add" value="Add">
				</td>
			</tr>
			</table>
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
								<?php if($script['process_id'] == 0):?>
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
	</div>	

	<script type="text/javascript">
		
		let addServerFormToggle = true
		let addScriptFormToggle = true


		$('.add-server-label').on('click',function(event){
			
			if(addServerFormToggle){
				$('.add-server-form-input-table').css({
					
					display:'block',
					transition:'2s'
				})
				addServerFormToggle=false
			}

			else{
				$('.add-server-form-input-table').css({
					
					display:'none',
					transition:'2s'
				})
				addServerFormToggle=true
			}
		})

		$('.add-script-label').on('click',function(event){
			
			if(addScriptFormToggle){
				$('.add-script-form-input-table').css({
					
					display:'block',
					transition:'2s'
				})
				addScriptFormToggle=false
			}

			else{
				$('.add-script-form-input-table').css({
					
					display:'none',
					transition:'2s'
				})
				addScriptFormToggle=true
			}
		})
	</script>

</body>
</html>