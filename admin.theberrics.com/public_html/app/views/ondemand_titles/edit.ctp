<?php 

$verb = "Edit On-Demand Title";

if($this->params['action'] == "add") {
	
	$verb = "Add New On-Demand Title";
	
}



$tag_str = '';

foreach($this->data['Tag'] as $tag) $tag_str .= $tag['name'].", ";

$tag_str = ltrim($tag_str,",");

$item_num = array();

for($i=1;$i<=99;$i++) $item_num[$i] = $i;

?>
<script>

$(document).ready(function() { 

	$( "#OndemandTitlePubDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});

	$("#OndemandTitlePubTime").timepicker({
	    showPeriod: false,
	    showLeadingZero: false
	});
	$("#OndemandTitleReleaseDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});
	
});

</script>
<div class="ondemandTitles form ">
<?php echo $this->Form->create('OndemandTitle',array("enctype"=>"multipart/form-data"));?>
	<fieldset>
 		<legend><?php echo $verb; ?></legend>
	<?php
	
		echo $this->Form->input('id');
		echo $this->Form->input('active');
		echo $this->Form->input('hd');
		echo $this->Form->input('pub_date');
		echo $this->Form->input('pub_time');
		echo $this->Form->input('release_date',array("type"=>"text"));
		echo $this->Form->input('title');
		echo $this->Form->input('description');
		echo $this->Form->input('user_id',array("label"=>"Video Owner"));
		echo $this->Form->input("tags",array("value"=>$tag_str));
		echo $this->Form->input('image_cover',array("type"=>"file","label"=>"Cover Image"));
		echo $this->Form->input('image_back',array("type"=>"file","label"=>"Back Cover Image"));
		
	?>
	</fieldset>
	
	<fieldset>
		<legend>
			Media Items
		</legend>
		<div class='media-items index'>
			<div>
				<?php 
					echo $this->Form->submit("Update");
					echo $this->Form->submit("Add Media File",array("name"=>"data[AddMediaFile]"));
					
				?>
			</div>
			<table cellspacing='0'>
				<?php foreach($this->data['OndemandTitleMediaItem'] as $key=>$item): $m = $item['MediaFile']; ?>
				<tr>
					<td nowrap width='1%'>
						<?php echo $this->Form->input("OndemandTitleMediaItem.{$key}.id"); ?>
						<?php echo $this->Form->input("OndemandTitleMediaItem.{$key}.display_weight",array("options"=>$item_num));?>
					</td>
					<td width='1%' nowrap>
						<?php echo $this->Form->input("OndemandTitleMediaItem.{$key}.active")?>
					</td>
					<td width='1%' nowrap>
						<?php echo $this->Form->input("OndemandTitleMediaItem.{$key}.trailer")?>
					</td>
					<td width='1%'>
						<?php echo $this->Media->mediaThumb(array("MediaFile"=>$m,"w"=>100)); ?>
					</td>
					<td><?php echo $m['name']; ?></td>
					<td></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
	</fieldset>
	
<?php echo $this->Form->end(__('Submit', true));?>
</div>