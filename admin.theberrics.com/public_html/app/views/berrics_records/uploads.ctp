<div class='index'>
	<h2>Uploads: <?php echo $record['BerricsRecord']['record_name']; ?></h2>
	<table cellspacing='0'>
		<tr>
			<th>ID</th>
			<th>Created</th>
			<th>User</th>
			<th>View File</th>
		</tr>
		<?php foreach($uploads as $u): ?>
		<tr>
			<td width='5%' align='center'><?php echo $u['MediaFileUpload']['id']; ?></td>
			<td width='10%' align='center' nowrap ><?php echo $this->Time->niceShort($u['MediaFileUpload']['created']); ?></td>
			<td><?php echo $u['User']['first_name']." ".$u['User']['last_name']; ?> <a href='http://facebook.com/profile.php?id=<?php echo $u['User']['facebook_account_num']; ?>' target='_blank'>(Facebook)</a></td>
			<td><a href='http://50.57.104.64/<?php echo $u['MediaFileUpload']['file_name']; ?>' target='_blank'>CLICK TO VIEW FILE</a></td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>