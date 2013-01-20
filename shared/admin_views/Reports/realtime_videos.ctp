<div class="page-header">
	<h1>Video Views <small>Generated: <?php echo date('g:i:s a'); ?></small></h1>
	<?php if (!$this->request->is("ajax")): ?>
	<a href="/reports/realtime_videos" class="btn btn-primary">Refresh</a>
	<?php endif; ?>
</div>
		<table>
			<thead>
				<tr>
					
					<th>Time</th>
					<th>File</th>
					<th>Country</th>
					<th>Region</th>
				</tr>
			</thead>
			<?php foreach ($media as $k=>$val): 
				$v = $val['MediaFileView'];
				$m = $val['MediaFile'];
			?>
			<tbody>
				<tr>
					
					<td><span class="label label-info"><?php echo date('g:i:s a',strtotime($v['created'])); ?></span></td>
					<td><?php echo $m['name']; ?></td>
					<td><?php echo $v['geo_country']; ?></td>
					<td><?php echo $v['geo_region_name']; ?></td>
				</tr>
			</tbody>
			<?php endforeach ?>
		</table>