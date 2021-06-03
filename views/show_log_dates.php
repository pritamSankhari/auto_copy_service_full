<div class="nav-bar">
	<a class="btn btn-start" href="<?= BASE_URL ?>">Back To Control Panel</a>
	<a class="btn btn-light-red" href="<?= BASE_URL.'do_action.php?action=do_logout' ?>">Log out</a>
</div>

<div class="status-msg-block">
	<?php show_status();?>
</div>

<section class="script-list-block">
	<form method="post" action="do_action.php">
		<?php if($log_dates):?>
			<h2 style="text-align: center;">Log Dates</h2>
			<div>
				<div style="background-color: darkslateblue;color: white;font-weight: 900;">
					<label>Select All Logs</label>
					<input class="selectall" type="checkbox" name="">

					<input type="hidden" name="action" value="remove_selected_log_date">
					<input type="hidden" name="script_id" value="<?= $script_id ?>">
					<input style="width: 200px;" class="btn btn-stop" type="submit" name="remove" value="Remove Selected">
				</div>
				
				<table id="show_log_table">
					<tr>
						<th>Log Dates</th>
						<th></th>
					</tr>

					<?php foreach($log_dates as $date):?>
					<tr style="border-bottom: 2px solid black;">
						
						<td style="border-bottom: 1px solid darkslateblue;">
							<?= $date['on_date']?>		
						</td>
						<td style="border-bottom: 1px solid darkslateblue;">
							<input class="log" type="checkbox" name="log_date[]" value="<?= $date['on_date']?>">
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
