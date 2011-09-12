<div class='index'>
	<table cellspacing='0'>
		<tr>
			<th>ID</th>
			<th>Section</th>
			<th>Name</th>
			<th>URL</th>
			<th>Actions</th>
		</tr>
		<?php 
		
			foreach($posts as $p):
		
		?>
		<tr>
			<td><?php echo $p['Dailyop']['id']; ?></td>
			<td><?php echo $p['DailyopSection']['name']; ?></td>
			<td><?php echo $p['Dailyop']['name']; ?></td>
			<td><?php echo $p['DailyopSection']['uri'] ?>/<?php echo $p['Dailyop']['uri']; ?></td>
			<td>
				<a href='/dailyops/edit/<?php echo $p['Dailyop']['id']; ?>/<?php echo base64_encode($this->here); ?>'>Edit</a>
			</td>
		</tr>
		<?php 
		
			endforeach;
		
		?>
	</table>
</div>