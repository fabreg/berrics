<div class='index'>
	<h2>La Jolla Tracking Files</h2>
	<table cellspacing='0'>
		<tr>
			<th><input type='checkbox' /></th>
			<th><?php echo $this->Paginator->sort("created")?></th>
			<th><?php echo $this->Paginator->sort("file_name")?></th>
			<th><?php echo $this->Paginator->sort("downloaded"); ?></th>
			<th><?php echo $this->Paginator->sort("processed"); ?></th>
			<th><?php echo $this->Paginator->sort("deleted"); ?></th>
			<th>-</th>
		</tr>
		<?php 
		
			foreach($files as $file): 
				$f = $file['LjgTrackingFile'];
		?>
		<tr>
			<td width='1%'>
			<?php if($f['processed']==0): ?>
				<input type='checkbox'/>
			<?php endif; ?>	
			</td>
			<td><?php echo $this->Time->niceShort($f['created'])?></td>
			<td><?php echo $f['file_name']; ?></td>
			<td><?php echo $f['downloaded']; ?></td>
			<td><?php echo $f['processed']; ?></td>
			<td><?php echo $f['deleted']; ?></td>
			<td class='actions'>
				<?php echo $this->Admin->link("View File",array("action"=>"view_lajolla_tracking_file",$f['id']),array("target"=>"_blank")); ?>
				<?php if($f['processed']==0) echo $this->Admin->link("Process File",array("action"=>"process_tracking_file",$f['id'])); ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>