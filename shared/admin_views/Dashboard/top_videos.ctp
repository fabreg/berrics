<h3>Top <?php echo $this->request->params['pass'][0]; ?> Videos</h3>
<table cellspacing='0'>
	<tr>
		<th>Video</th>
		<th>Views</th>
	</tr>
	<?php foreach($videos as $v): ?>
	<tr>
		<td><small><?php echo $v['MediaFile']['name']; ?></small></td>
		<td><?php echo number_format($v[0]['total']); ?></td>
	</tr>
	<?php endforeach; ?>
</table>