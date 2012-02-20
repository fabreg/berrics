<div class='form index'>
	<?php echo $this->Form->create("MediaFile",array("url"=>$this->here))?>
	<fieldset>
		<legend>Details</legend>
		<?php 
			
			echo $this->Form->input("MediaFile.id");
			echo $this->Form->input("MediaFile.name");
			
		?>
	</fieldset>
	
	<?php 
		
		switch($this->data['MediaFile']['media_type']) {
	
			case "bcove":
				echo $this->element("media_files/inspect_video_still");
				echo $this->element("media_files/inspect_limelight");
				break;
			case "img":
				break;
			
		}
	?>
	<fieldset>
		<legend>Advertising Tags</legend>
		<?php 
			
			echo $this->Form->input("MediaFile.preroll_label",array("options"=>Arr::adLabels(),"empty"=>true));
			echo $this->Form->input("MediaFile.preroll_tags");
			echo $this->Form->input("MediaFile.preroll_label_override");
			echo $this->Form->input("MediaFile.postroll_label",array("options"=>Arr::adLabels(),"empty"=>true));
			echo $this->Form->input("MediaFile.postroll_tags");
			echo $this->Form->input("MediaFile.postroll_label_override");
		?>
	</fieldset>
	<?php 
	
		echo $this->Form->end("Update");
	
	?>
</div>