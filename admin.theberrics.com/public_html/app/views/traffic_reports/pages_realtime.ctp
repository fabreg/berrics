<?php 
$c = Arr::countries();
?>
<div class='index'>
	<h2>Page View: Real-time</h2>
	<table cellspacing='0'>
		<tr>
			<th>Thread ID</th>
			<th>Date/Time</th>
			<th>Country</th>
			<th>Region/City</th>
			<th>URL</th>
		</tr>
		<?php foreach($pages as $page): $p = $page['PageView']; ?>
		<tr>
			<td><?php echo $p['id']; ?></td>
			<td><?php echo $this->Time->niceShort($p['created']); ?></td>
			<td><?php echo $c[$p['geo_country']]; ?></td>
			<td><?php echo $p['geo_region_name']; ?>/<?php echo $p['geo_city']; ?></td>
			<td><a href='http://theberrics.com<?php echo $p['script_url']; ?>' target='_blank'><?php echo $p['script_url']; ?></a></td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>