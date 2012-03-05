<?php 

echo $this->element("dashboard/tab-nav");

?>
<div class='index'>
	<h2>Younited Nations Entries With Uploads</h2>
	<div style='padding:10px;'><strong>Number of uploads:</strong> <?php echo count($entries); ?></div>
	<table cellspacing='0'>
		<tr>
			<th>ID</th>
			<th>Entry Date</th>
			<th>Posse Name</th>
			<th>GEO Location</th>
			<th>Uploads</th>
		</tr>
		<?php foreach($entries as $v): ?>
		<tr>
			<td><?php echo $v['YounitedNationsEventEntry']['id']; ?></td>
			<td><?php echo $this->Time->niceShort($v['YounitedNationsEventEntry']['created']); ?></td>
			<td><?php echo $v['YounitedNationsPosse']['name']; ?></td>
			<td><?php echo $v['YounitedNationsPosse']['geo_formatted']; ?></td>
			<td>
				<?php foreach($v['MediaFileUpload'] as $u): ?>
					<a href='http://50.57.104.64/<?php echo $u['file_name']; ?>' target='_blank'><span style='font-size:20px; font-weight:bold;'><?php echo strtoupper($u['notes']); ?></span> (Date: <?php echo $this->Time->niceShort($u['created']); ?>)</a><br />
				<?php endforeach; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>