<style>
	#browse-table tbody tr td {

		font-size:12px;

	}
</style>
<?php 

$mediaTypes = MediaFile::mediaFileTypes();

 ?>
<?php echo $this->Admin->adminPaging(); ?>
<h5>Filter</h5>
<?php echo  $this->Form->create('MediaFile',array(
	"id"=>'MediaFileForm',
	"url"=>"/attach_media/filter"
)); ?>
<div class="row-fluid">
	<div class="span12 well well-small">
		<?php echo $this->Form->input("name"); ?>
		<?php echo $this->Form->input("website_id"); ?>
		<?php echo $this->Form->input("media_type",array("options"=>$mediaTypes,"empty"=>true)) ?>
		<button class="btn btn-primary btn-mini">Filter</button>
	</div>
</div>
<?php echo $this->Form->end(); ?>
<table cellspacing='0' id='browse-table'>
	<thead>
		<tr>
			<th>Thumb</th>
			<th><?php echo $this->Paginator->sort("modified"); ?></th>
			<th><?php echo $this->Paginator->sort("media_type"); ?></th>
			<th><?php echo $this->Paginator->sort("name"); ?></th>
			<th>Website</th>
			<th>-</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($files as $k => $file): ?>
		<tr>
			<td width='1%'>
				<?php echo $this->Media->mediaThumb(array(
					"MediaFile"=>$file['MediaFile'],
					"w"=>125,
					"h"=>75
				)); ?>
			</td>
			<td>
				<?php echo $this->Time->niceShort($file['MediaFile']['modified']); ?>
			</td>
			<td width='1%' nowrap>
				<span class="label label-info"><?php echo strtoupper($mediaTypes[$file['MediaFile']['media_type']]); ?></span>
			</td>
			<td>
				<?php echo $file['MediaFile']['name']; ?>
			</td>
			<td><?php echo $file['Website']['name']; ?></td>
			<td class='actions'>
				<a href="#" rel='no-ajax' class="btn btn-success btn-small attach-btn" data-media-file-id='<?php echo $file['MediaFile']['id']; ?>' data-thumb='<?php echo $this->Media->mediaThumbSrc(array("MediaFile"=>$file['MediaFile'],"w"=>75)); ?>' data-media-type='<?php echo $mediaTypes[$file['MediaFile']['media_type']]; ?>'>Select File</a>
			</td>
		</tr>
		<?php endforeach ?>
	</tbody>
</table>
<?php echo $this->Admin->adminPaging(); ?>