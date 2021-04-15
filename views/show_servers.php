<div class="nav-bar">
	<a class="btn btn-start" href="<?= BASE_URL ?>">Back To Control Panel</a>
	<a class="btn btn-light-red" href="<?= BASE_URL ?>">Log out</a>
</div>

<div class="status-msg-block">
	<?php show_status();?>
</div>

<section class="script-list-block">
	
	<?php if($servers):?>
		<div>
			<table>
				<tr>
					<th>Server Name</th>
					<th>Path</th>
					<th>Status</th>
					<th>Action</th>
				</tr>

				<?php foreach($servers as $server):?>
				<tr>
					<td>
						<?= $server['name']?>		
					</td>	
					<td>
						<?= $server['path']?>		
					</td>
					<td>
						<?php if($server['in_use']):?>
							Server is Running ...

						<?php else:?>
							Server is Ideal
						<?php endif;?>
					</td>
					<td>
						<a href="<?= BASE_URL.'do_action.php?action=remove_server&server_id='.$server['id'] ?>"><button class="btn-stop">Delete</button></a>
					</td>
				</tr>
				<?php endforeach;?>
			</table>
		</div>

	<?php else:?>
		<h3>No Server registered !</h3>
	<?php endif;?>
</section>
