<?php 


$total_uniques = $report['Report']['data_formatted']['total_uniques'][0]['total'];

$total_pageviews = $report['Report']['data_formatted']['total_pageviews'][0]['total'];

$total_mobile_pageviews = $report['Report']['data_formatted']['total_mobile_views'][0]['total'];
?>
<div class='page-header'>
	<h3><?php echo $report['Report']['title']; ?></h3>
</div>
<div class='well well-small'>
	<?php 
		$p = unserialize($report['Report']['params_data']);
		
		foreach($p as $k=>$v) {
			
			echo "[ ".Inflector::humanize($k)." : ".$v." ]";
			
		}
	?>
</div>
<div class='row-fluid'>
			<div class='span4'>
				<div class='well'>
					<h1><?php echo number_format($total_uniques); ?> <small style='white-space:nowrap;'>Uniques Visitors</small></h1>
				</div>
			</div>
			<div class='span4'>
				<div class='well'>
					<h1><?php echo number_format($total_pageviews); ?> <small style='white-space:nowrap;'>Page Views</small></h1>
				</div>
			</div>
			<div class='span4'>
				<div class='well'>
					<h1><?php echo number_format($total_mobile_pageviews); ?> <small style='white-space:nowrap;'>Mobile Views</small></h1>
				</div>
			</div>
		</div>
<div>
	<em>* Showing top 100 url's</em>
	<table cellspacing='0'>
		<thead>
			<tr>
				<th>URL</th>
				
				<th>Page Views</th>
				
			</tr>	
		</thead>
		<tbody>
			<?php 
			
				foreach($report['Report']['data_formatted']['pageviews'] as $v): 
			
				
				
			?>
			<tr>
				<td><?php echo $v['uri']; ?></td>
				<td><?php echo number_format($v['total']); ?></td>
			</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</div>
