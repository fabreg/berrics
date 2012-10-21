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

//die(pr($report['Report']['data_formatted']));

//get all the totals

$total_uniques = array_sum(Set::classicExtract($report,'Report.data_formatted.uniques.{n}.total'));

$total_pageviews = array_sum(Set::classicExtract($report,'Report.data_formatted.pageviews.{n}.total'));

$total_mobile_pageviews = array_sum(Set::classicExtract($report,'Report.data_formatted.mobile_views.{n}.total'));

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
		<div class='row-fluid'>
			<div class='span12'>
				<table cellspacing='0'>
					<thead>
						<tr>
							<th>Date</th>
							<th>Uniques</th>
							<th>Page views</th>
							<th>Mobile Views</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						
							foreach($report['Report']['data_formatted']['uniques'] as $v): 
						
							$pv = search($report['Report']['data_formatted']['pageviews'],"date_str",$v['date_str']);
							
							$mv = search($report['Report']['data_formatted']['mobile_views'],"date_str",$v['date_str']);
							
						?>
						<tr>
							<td><?php echo date("F dS Y",strtotime($v['date_str'])); ?></td>
							<td><?php echo number_format($v['total']); ?></td>
							<td><?php echo number_format($pv[0]['total']); ?></td>
							<td><?php echo number_format($mv[0]['total']); ?></td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class='page'>
		<h3>Countries</h3>
		<table cellspacing='0'>
			<thead>
				<tr>
					<th>Country</th>
					<th>Uniques</th>
					<th>Page Views</th>
					<th>Mobile Views</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($report['Report']['data_formatted']['country_uniques'] as $v): 
			
			$pv = search($report['Report']['data_formatted']['country_pageviews'],"country_code",$v['country_code']);
				
			$mv = search($report['Report']['data_formatted']['country_mobile_views'],"country_code",$v['country_code']);
			
			?>
			<tr>
				<td><?php echo (!empty($v['country_code']) && array_key_exists($v['country_code'],$c)) ? $c[$v['country_code']]:"?"; ?></td>
				<td><?php echo number_format($v['total']); ?></td>
				<td><?php echo number_format($pv[0]['total']); ?></td>
				<td><?php echo (!isset($mv[0])) ? "0":number_format($mv[0]['total']); ?></td>
			</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<?php

//pr($report)

?>