<?php 

$verb = "Edit On-Demand Title";

if($this->params['action'] == "add") {
	
	$verb = "Add New On-Demand Title";
	
}



$tag_str = '';

foreach($this->data['Tag'] as $tag) $tag_str .= $tag['name'].", ";

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
<div class="ondemandTitles form">
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
<?php echo $this->Form->end(__('Submit', true));?>
</div>