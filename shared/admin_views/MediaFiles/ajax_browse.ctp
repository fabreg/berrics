<script>


</script>
<?php 

$mediaTypes = MediaFile::mediaFileTypes();


?>
<div class='index'>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
<table cellspacing='0'>
	<tr>
		<th>
			<?php echo $this->Paginator->sort("Created","MediaFile.created"); ?>
		</th>
		<th>
			Thumbnail
		</th>
		<th>
			<?php echo $this->Paginator->sort("User","User.email"); ?>
		</th>
		<th>
			<?php echo $this->Paginator->sort("Name","MediaFile.name"); ?>
		</th>
		<th><?php echo $this->Paginator->sort("Type","Media.media_type"); ?>
		<th>
			Actions
		</th>
	</tr>
	<?php 
		foreach($files as $file):
		$m = $file['MediaFile'];
		$u = $file['User'];
		
	?>
	<tr media_file_id='<?php echo $m['id']; ?>'>
		<td>
			<?php echo $m['created']; ?>
		</td>
		<td class='thumb'>
			<?php echo $this->Media->mediaThumb(array(
				
					"MediaFile"=>$m,
					"w"=>75,
					"h"=>75
			
				));?>
		</td>
		<td>
			<?php echo $u['email']; ?>
		</td>
		<td>
			<?php echo $m['name']; ?>
		</td>
		<td>
			<?php echo $mediaTypes[$m['media_type']]; ?>
		</td>
		<td class='actions'>
			<?php echo $this->Admin->link("Attach",array(),array("rel"=>"attach_link","media_file_id"=>$m['id'])); ?>
		</td>
	</tr>
	<?php 
		
		endforeach;
	
	?>

</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>