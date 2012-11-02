<?php 
$tag_array = Set::extract("/Tag/name",$this->request->data);

$tag_str = implode(",",$tag_array);
?>
<div class='page-header'>
	<h1>Edit Media File</h1>
</div>
	<?php echo $this->Form->create("MediaFile",array("url"=>$this->request->here))?>
	
<div class='row-fluid'>
	<div class='span6'>
		<fieldset>
			<legend>Details</legend>
			<dl>
				<dt>ID</dt>
				<dd><?php echo $this->request->data['MediaFile']['id']; ?></dd>
			</dl>
			<?php 
				
				echo $this->Form->input("MediaFile.id");
				echo $this->Form->input("MediaFile.name");
				echo $this->Form->input("MediaFile.caption");
				echo $this->Form->input("tags",array("value"=>$tag_str));
				echo $this->Form->submit("Update");
				
			?>
		</fieldset>
		<fieldset>
			<legend>Advertising Tags</legend>
			<div class='alert alert-danger'>These properties only apply to video</div>
			<?php 
				
				echo $this->Form->input("MediaFile.preroll_label",array("options"=>Arr::adLabels(),"empty"=>true));
				echo $this->Form->input("MediaFile.preroll_tags");
				echo $this->Form->input("MediaFile.preroll_label_override");
				echo $this->Form->input("MediaFile.postroll_label",array("options"=>Arr::adLabels(),"empty"=>true));
				echo $this->Form->input("MediaFile.postroll_tags");
				echo $this->Form->input("MediaFile.postroll_label_override");
				echo $this->Form->submit("Update");
				
			?>
		</fieldset>
	</div>
	<div class='span6'>
			<?php 
		
		switch($this->request->data['MediaFile']['media_type']) {
	
			case "bcove":
				echo $this->element("media_files/inspect_video_still");
				echo $this->element("media_files/inspect_limelight");
				break;
			case "img":
				echo $this->element("media_files/inspect_image");
				echo $this->element("media_files/inspect_image_link");
				break;
			
		}
	?>
	</div>
</div>


	<?php 
	
		echo $this->Form->end("Update");
	
	?>