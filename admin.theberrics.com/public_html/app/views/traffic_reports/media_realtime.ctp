<div class='index'>

	<h2>Media File Views -  Realtime</h2>
	<table cellspacing='0'>
		<tr>
			<th>View ID</th>
			<th>Date/Time</th>
			<th>Media File</th>
			<th>Location</th>
		</tr>
		<?php 
			foreach($realtime as $v):
		?>
		<tr>
			<td><?php echo $v['MediaFileView']['id']; ?></td>
			<td><?php echo $v['MediaFileView']['created']; ?></td>
			<td><?php echo $v['MediaFile']['name']; ?> <span style='font-size:10px; font-style:italic;'><a href='/media_files/edit/<?php echo $v['MediaFile']['id']; ?>'>(Edit)</a></span>&nbsp;&nbsp;<span style='font-size:10px; font-style:italic;'><a href='/traffic_reports/media_file_details/media_file_id:<?php echo $v['MediaFile']['id']; ?>/date_start:2011-06-20/date_end:<?php echo date("Y-m-d"); ?>'>(Report)</a></span></td>
			<td><?php echo $v['MediaFileView']['geo_country']; ?> - <?php echo $v['MediaFileView']['geo_region_name']; ?></td>
		</tr>
		<?php 
			endforeach;
		?>
	</table>
</div>