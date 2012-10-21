<div class='index'>
	<h2>Media File Uploads</h2>
	<table cellspacing='0' style='font-size:12px;' >
		<tr>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th><?php echo $this->Paginator->sort("created"); ?></th>
			<th>User</th>
			<th><?php echo $this->Paginator->sort("file_name"); ?></th>
			<th><?php echo $this->Paginator->sort("name"); ?></th>
			<th><?php echo $this->Paginator->sort("notes"); ?></th>
			<th><?php echo $this->Paginator->sort("model"); ?></th>
			<th><?php echo $this->Paginator->sort("foreign_key"); ?></th>
			<th>-</th>
		</tr>
		<?php foreach($data as $f): ?>
		<tr>
			<td><?php echo $f['MediaFileUpload']['id']; ?></td>
			<td align='center'><?php echo $this->Time->niceShort($f['MediaFileUpload']['created']); ?></td>
			<td align='center'>
				<a href='/users/edit/<?php echo $f['User']['id']; ?>'><?php echo $f['User']['first_name']; ?> <?php echo $f['User']['last_name']; ?></a>
				 <a href='http://facebook.com/profile.php?id=<?php echo $f['User']['facebook_account_num']; ?>' target='_blank'>Facebook</a>
			</td>
			<td align='center'><?php echo $f['MediaFileUpload']['file_name']; ?><span style='padding-left:10px;'><a href='http://<?php echo $upload_server; ?>/<?php echo $f['MediaFileUpload']['file_name']; ?>' target='_blank'>Download</a></span></td>
			<td align='center'><?php echo $f['MediaFileUpload']['name']; ?></td>
			<td align='center'><?php echo $f['MediaFileUpload']['notes']; ?></td>
			<td align='center'><?php echo $f['MediaFileUpload']['model']; ?></td>
			<td align='center'><?php echo $f['MediaFileUpload']['foreign_key']; ?></td>
			<td class='actions'>
				<a href='/media_file_uploads/edit/<?php echo $f['MediaFileUpload']['id']; ?>/<?php echo base64_encode($this->here); ?>'>Edit</a>
				<a></a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>