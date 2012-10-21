<div class='index'>
	<h2>Younited Nations 3 Voting</h2>
	<div><strong>Total Votes: </strong><?php echo number_format($gt); ?></div>
	<table cellspacing='0'>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Votes</th>
			<th>%</th>
		</tr>
		<?php foreach($stats as $v): ?>
		<tr>
			<td><?php echo $v['YounitedNationsEventEntry']['id']; ?></td>
			<td><?php echo $v['YounitedNationsPosse']['name']; ?></td>
			<td><?php echo number_format($v[0]['votes']); ?></td>
			<td><?php echo number_format(($v[0]['votes']/$gt)*100,2); ?>%</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>