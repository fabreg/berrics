<div class="page-header">
	<h1>Page Views <small>Generated: <?php echo date('g:i:s a'); ?></small></h1>
	<?php if (!$this->request->is("ajax")): ?>
	<a href="/reports/realtime_pages" class="btn btn-primary">Refresh</a>
	<?php endif; ?>
</div>
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
					<td><a href="http://theberrics.com<?php echo $p['script_url']; ?>" target='_blank'><?php echo $this->Text->truncate($p['script_url'],60); ?></a></td>
					<td><?php echo $p['geo_country']; ?></td>
					<td><?php echo $p['geo_region_name']; ?></td>
					
				</tr>
			</tbody>
			<?php endforeach ?>
			
		</table>