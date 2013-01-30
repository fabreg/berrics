<style>
	.report-table {
	
		border:1px solid #000;
		border-top:none;
		border-left:none;
	
	}
	
	.report-table td,.report-table td {
	
		border:1px solid #000;
		border-right:none;
		border-bottom:none;
		padding:5px;
		text-align:center;
	}
</style>
<div>
<h4>Top 100 Videos</h4>

<table cellspacing='0' cellpadding='0' class='report-table'>
	<tr>
		<th>-</th>
		<th>Video</th>
		<th>Views</th>
	</tr>
	<?php 
		$data = unserialize($msg['EmailMessage']['serialized_data']);
		foreach($data as $k=>$d):
	?>
	<tr>
		<td><?php echo ($k+1); ?></td>
		<td>
			<?php echo $d['MediaFile']['name']; ?>
		</td>
		<td>
			<?php echo number_format($d[0]['total']); ?>
		</td>
	</tr>
	<?php 
		endforeach;
	?>
</table>
</div>
<pre>
<?php 

//print_r($msg);

//print_r(unserialize($msg['EmailMessage']['serialized_data']));

?>
</pre>