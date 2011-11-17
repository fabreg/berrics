<div class='index'>
	<table cellspacing='0' >
		<tr>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th><?php echo $this->Paginator->sort("created"); ?></th>
			<th><?php echo $this->Paginator->sort("modified"); ?></th>
			<th><?php echo $this->Paginator->sort("file_name"); ?></th>
			<th><?php echo $this->Paginator->sort("name"); ?></th>
			<th><?php echo $this->Paginator->sort("notes"); ?></th>
			<th>-</th>
		</tr>
		<?php foreach($data as $f): ?>
		<tr>
			<td><?php echo $f['MediaFileUpload']['id']; ?></td>
			<td><?php echo $f['MediaFileUpload']['created']; ?></td>
			<td><?php echo $f['MediaFileUpload']['modified']; ?></td>
			<td><?php echo $f['MediaFileUpload']['file_name']; ?></td>
			<td><?php echo $f['MediaFileUpload']['name']; ?></td>
			<td><?php echo $f['MediaFileUpload']['notes']; ?></td>
			<td class='actions'>
				<a href='/media_file_uploads/edit/<?php echo $f['MediaFileUpload']['id']; ?>/<?php echo base64_encode($this->here); ?>'>Edit</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>