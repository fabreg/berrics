<div class="page-header">
	<h1>Realtime <small>Generated: <?php echo date('g:i:s a'); ?></small></h1>
</div>
<div class="row-fluid">
	<div class="span6">
		<h3>Page Views</h3>
		<table>
			<thead>
				<tr>
					
					<th>Time</th>
					<th>URI</th>
					<th>Country</th>
					<th>Region</th>
					
				</tr>
			</thead>
			<?php foreach ($pages as $k=>$v): 
					$p = $v['PageView'];
			?>
			<tbody>
				<tr>
					
					<td><span class="label label-info"><?php echo date('g:i:s a',strtotime($p['created'])); ?></span></td>
					<td><a href="http://theberrics.com<?php echo $p['script_url']; ?>" target='_blank'><?php echo $p['script_url']; ?></a></td>
					<td><?php echo $p['geo_country']; ?></td>
					<td><?php echo $p['geo_region_name']; ?></td>
					
				</tr>
			</tbody>
			<?php endforeach ?>
			
		</table>
	</div>
	<div class="span6">
		<h3>Media File</h3>
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
	</div>
</div>