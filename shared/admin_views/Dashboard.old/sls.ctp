<div class='index'>
	<h2>Street League Qualifying Stats</h2>
	<div>
	<strong>Total Votes: </strong><?php echo number_format($stats['GrandTotal']); ?>
	</div>
	<table cellspacing='0'>
		<tr>
			<th>Place</th>
			<th>Entry</th>
			<th>Total Votes</th>
			<th>Percentage</th>
		</tr>
		<?php 
			$i = 1;
			foreach($stats['Stats'] as $k=>$s):   ?>
		<tr>
			<td><?php echo $i; ?></td>
			<td><?php echo $s['SlsEntry']['name']; ?> 
			<span style='font-size:11px;'><a href='/dailyops/edit/<?php Echo $s['SlsEntry']['dailyop_id']; ?>/<?php Echo base64_encode($this->here); ?>' >(Edit Post)</a></span>
			<span style='font-size:11px;'><a href='/sls/edit_entry/<?php Echo $s['SlsEntry']['dailyop_id']; ?>/<?php Echo base64_encode($this->here); ?>' >(Edit Entry)</a></span>
			</td>
			<td><?php echo number_format($s[0]['total_votes']); ?></td>
			<td>%<?php echo $s['Percentage']; ?></td>
		</tr>
		<?php 
			$i++;
			endforeach; ?>
	</table>
</div>