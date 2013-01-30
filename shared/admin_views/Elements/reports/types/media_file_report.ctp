<script>

$(document).ready(function() { 

	initBootstrap();

	
});

</script>
<?php 

$c = Arr::countries();

?>
<div class="page-header">
	<h2>Media File Report</h2>
	<h3><?php echo $report['Report']['title']; ?></h3>
</div>
<div class="well well-small">
	<?php 
		$p = unserialize($report['Report']['params_data']);
		
		foreach($p as $k=>$v) {
			
			echo "[ ".Inflector::humanize($k)." : ".$v." ]";
			
		}
	?>
</div>
<div class="row-fluid">
	<div class="span6">
		<div class="well">
			<h1>
				<?php echo number_format($report['Report']['data_formatted']['views'][0]['total']); ?> <small>Total Views</small>
			</h1>
		</div>
	</div>
	<div class="span6">
		<div class="well">
			<h1><?php echo number_format($report['Report']['data_formatted']['mobile_views'][0]['total']); ?> <small>Mobile Views</small></h1>
		</div>
	</div>
</div>
<table cellspacing="0">
	<thead>
		<tr>
			<th>Country</th>
			<th>Views</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($report['Report']['data_formatted']['country_view'] as $key => $value): ?>
		<tr>
			<td><?php echo (empty($value['country_code'])) ? "?":$c[$value['country_code']]; ?></td>
			<td><?php echo number_format($value['total']); ?></td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>