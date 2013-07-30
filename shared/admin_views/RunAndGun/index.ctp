<script>
	
	
function grabScore ($dailyop_id) {
	
	
	
}

</script>
<div class="page-header">
	<h1>Run And Gun</h1>
</div>
<table cellpadding='0'>
	<tr>
		<th>PostID</th>
		<th>Publish Date</th>
		<th>Title</th>
		<th>Total Votes</th>
		<th>Average Score</th>
		<th>Actions</th>
	</tr>
	<?php foreach ($posts as $k => $v): ?>
	<tr data-post-id='<?php echo $v['Dailyop']['id']; ?>'>
		<td><?php echo $v['Dailyop']['id']; ?></td>
		<td><?php echo $this->Time->niceShort($v['Dailyop']['publish_date']) ?></td>
		<td><?php echo $v['Dailyop']['name'] ?> - <?php echo $v['Dailyop']['sub_title']; ?></td>
		<td class='total-votes'></td>
		<td class='average-score'></td>
		<td>
			<a href="/dailyops/edit/<?php echo $v['Dailyop']['id']; ?>" class="btn btn-primary">Edit</a>
		</td>
	</tr>
	<?php endforeach ?>
</table>