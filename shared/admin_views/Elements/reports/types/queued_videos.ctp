<?php 
$media_ids = Set::extract("/total_views/media_file_id",$report['Report']['data_formatted']);
$MediaFile = ClassRegistry::init("MediaFile");
$files = $MediaFile->find("all",array(
	"conditions"=>array(
		"MediaFile.id"=>$media_ids
	),
	"contain"=>array()
));

$totals = array_sum(Set::extract('/total_views/total',$report['Report']['data_formatted']));

$total_mobile = array_sum(Set::extract('/total_mobile/total',$report['Report']['data_formatted']));

$params = unserialize($report['Report']['params_data']);

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
?>

<div class="page-header">
	<h1>Queued Videos <br /><small><strong>Date Start:</strong> <?php echo $params['start_date']  ?> <strong>End Date:</strong> <?php echo $params['end_date']; ?></small></h1>
</div>
<div>
	<h3><?php echo $report['Report']['title']; ?></h3>
</div>
<div class='row-fluid'>
	<div class='span4'>
		<div class='well'>
			<h1><?php echo number_format($totals); ?> <small style='white-space:nowrap;'>Total Views</small></h1>
		</div>
	</div>
	<div class='span4'>
		<div class='well'>
			<h1><?php echo number_format($total_mobile); ?> <small style='white-space:nowrap;'>Total Mobile</small></h1>
		</div>
	</div>
	<div class='span4'>
		
	</div>
</div>
<table cellspacing="0">
	<thead>
		<tr>
			<th>#</th>
			<th>Media File</th>
			<th>Total Views</th>
			<th>Mobile Views</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			foreach ($report['Report']['data_formatted']['total_views'] as $k => $v): 
			$file = Set::extract("/MediaFile[id={$v['media_file_id']}]",$files);
			$mobile = Set::extract("/total_mobile[media_file_id={$v['media_file_id']}]",$report['Report']['data_formatted']); //search($report['Report']['data_formatted']['mobile_views'],"media_file_id",$v['media_file_id']);
			
		?>
		<tr>
			<td><?php echo $k+1; ?></td>
			<td>
				<?php echo $file[0]['MediaFile']['name']; ?>
			</td>
			<td><?php echo number_format($v['total']); ?></td>
			<td><?php echo number_format($mobile[0]['total_mobile']['total']); ?></td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>