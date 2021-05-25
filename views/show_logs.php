<div class="nav-bar">
	<a class="btn btn-start" href="<?= BASE_URL ?>">Back To Control Panel</a>
	<a class="btn btn-light-red" href="<?= BASE_URL.'do_action.php?action=do_logout' ?>">Log out</a>
</div>

<div class="status-msg-block">
	<?php show_status();?>
</div>

<section class="script-list-block">
	<form method="post" action="do_action.php">
		<?php if($script_logs):?>
			<h2 style="text-align: center;">Server(s)</h2>
			<div>
				<div style="background-color: darkslateblue;color: white;font-weight: 900;">
					<label>Select All Logs</label>
					<input class="selectall" type="checkbox" name="">

					<input type="hidden" name="action" value="remove_selected_logs">
					<input type="hidden" name="script_id" value="<?= $script_id ?>">
					<input style="width: 200px;" class="btn btn-stop" type="submit" name="remove" value="Remove Selected">
					
				</div>
				
				<table id="show_log_table">
					<tr><th></th>
						<th>Filename</th>
						<th>Date</th>
						<th>Time</th>
						
						<!-- <th>Action</th> -->
					</tr>

					<?php foreach($script_logs as $log):?>
					<tr style="border-bottom: 2px solid black;">
						<td style="border-bottom: 1px solid darkslateblue;">
							<input class="log" type="checkbox" name="log_id[]" value="<?= $log['id']?>">
						</td>
						<td style="border-bottom: 1px solid darkslateblue;">
							<?= $log['copied_file']?>		
						</td>	
						<td style="border-bottom: 1px solid darkslateblue;">
							<?= $log['on_date']?>		
						</td>
						<td style="border-bottom: 1px solid darkslateblue;">
							<?= $log['at_time']?>		
						</td>
						
						<!-- <td style="border-bottom: 1px solid darkslateblue;">
							<a><button class="btn-stop" onclick="confirmDelete(<?php echo $log['id']?>,<?= $script_id ?>)">Delete</button></a>	
						</td> -->
					</tr>
					<?php endforeach;?>
				</table>
			</div>

		<?php else:?>
			<h3>No Logs Found !</h3>
		<?php endif;?>
	</form>
</section>

<script type="text/javascript">

	let checkedall = false
	$(".selectall").on("input",function(event){

		if(checkedall){

			$("input.log").prop('checked',false)

			checkedall = false
		}

		else{

			$("input.log").prop('checked',true)	

			checkedall = true
		} 
			
		
	})

	$("input.log").on("input",function(event){

		checkedall = false
		$(".selectall").prop('checked',false)

	})

	function confirmDelete(id,script_id){

		$("form").prop("method","get")
		let i = confirm("Are you sure ?")
		if(i) window.location.assign("<?= BASE_URL.'do_action.php?action=remove_log&log_id=' ?>" + id + "&script_id=" + script_id)
		return true;	
	}
</script>
