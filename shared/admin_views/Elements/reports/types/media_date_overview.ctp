<?php 

//die(pr($report['Report']['data_formatted']));

?>
<script>

$(document).ready(function() { 

	initBootstrap();

	
});

</script>
<?php 

function search($array, $key, $value)
{
	$results = array();

	if (is_array($array))
	{
		if (isset($array[$key]) && $array[$key] == $value)
			$results[] = $array;

		foreach ($array as $subarray)
			$results = array_merge($results, search($subarray, $key, $value));
	}

	return $results;
}

//get all the totals

$total_views = array_sum(Set::classicExtract($report,'Report.data_formatted.total_views.{n}.total'));

$mobile_views = array_sum(Set::classicExtract($report,'Report.data_formatted.mobile_views.{n}.total'));

$c = Arr::countries();

?>

<div class='page-header'>
	<h2><?php echo $report['Report']['title']; ?></h2>
</div>
<div class='well well-small'>
	<?php 
		$p = unserialize($report['Report']['params_data']);
		
		foreach($p as $k=>$v) {
			
			echo "[ ".Inflector::humanize($k)." : ".$v." ]";
			
		}
	?>
</div>
<div class='report'>
	<div class='page'>
		<div class='row-fluid'>
			<div class='span6'>
				<div class='well'>
					<h1><?php echo number_format($total_views); ?> <small style='white-space:nowrap;'>Total Views</small></h1>
				</div>
			</div>
			<div class='span6'>
				<div class='well'>
					<h1><?php echo number_format($mobile_views); ?> <small style='white-space:nowrap;'>Mobile Views</small></h1>
				</div>
			</div>
		</div>
		<div class='row-fluid'>
			<div class='span12'>
				<table cellspacing='0'>
					<thead>
						<tr>
							<th>Date</th>
							<th>Views</th>
							<th>Mobile Views</th>
							
						</tr>
					</thead>
					<tbody>
						<?php 
						
							foreach($report['Report']['data_formatted']['total_views'] as $v): 

							$mv = search($report['Report']['data_formatted']['mobile_views'],"date_str",$v['date_str']);
							
						?>
						<tr>
							<td><?php echo date("F dS Y",strtotime($v['date_str'])); ?></td>
							<td><?php echo number_format($v['total']); ?></td>
							<td><?php echo number_format($mv[0]['total']); ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>
<?php

//pr($report)

?>