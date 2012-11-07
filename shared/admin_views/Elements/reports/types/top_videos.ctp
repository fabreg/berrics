<?php 
$media_ids = Set::extract("/total_views/media_file_id",$report['Report']['data_formatted']);
$MediaFile = ClassRegistry::init("MediaFile");
$files = $MediaFile->find("all",array(
	"conditions"=>array(
		"MediaFile.id"=>$media_ids
	),
	"contain"=>array()
));

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
	<h1>Top Videos <br /><small><strong>Date Start:</strong> <?php echo $params['start_date']  ?> <strong>End Date:</strong> <?php echo $params['end_date']; ?></small></h1>
</div>
<div>
	<h3><?php echo $report['Report']['title']; ?></h3>
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
			$mobile = Set::extract("/mobile_views[media_file_id={$v['media_file_id']}]",$report['Report']['data_formatted']); //search($report['Report']['data_formatted']['mobile_views'],"media_file_id",$v['media_file_id']);

		?>
		<tr>
			<td><?php echo $k+1; ?></td>
			<td>
				<?php echo $file[0]['MediaFile']['name']; ?>
			</td>
			<td><?php echo number_format($v['total']); ?></td>
			<td><?php echo number_format($mobile[0]['mobile_views']['total']); ?></td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>