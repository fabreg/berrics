<div class='index'>
	<h2>Street League</h2>
	<table cellspacing='0'>
		<tr>
			<th>ID</th>
			<th>Post</th>
			<th>Name</th>

			<th>Active</th>
			<th>Sort Order</th>
			<th>-</th>
		</tr>
		<?php foreach($data as $v): ?>
		<tr>
			<td><?php echo $v['SlsEntry']['id']; ?></td>
			<td><?php echo $v['Dailyop']['name']; ?>-<?php echo $v['Dailyop']['sub_title']; ?> <span style='font-size:10px;'><a href='/dailyops/edit/<?php echo $v['Dailyop']['id']; ?>' target='_blank'>(Edit Post)</a></span></td>
			
			<td><?php echo $v['SlsEntry']['name']; ?></td>
			<td>
				<?php 
					
					switch($v['SlsEntry']['active']) {
						
						case 1:
							echo "<span style='color:green;'>Yes</span>";
							break;
						default:
							echo "<span style='color:red;'>No</span>";
							break;
						
					}
				
				?>
			</td>
			<td><?php echo $v['SlsEntry']['sort_order']; ?></td>
			<td class='actions'>
				<a href='/sls/edit_entry/<?php echo $v['SlsEntry']['id']; ?>'>Edit</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>
