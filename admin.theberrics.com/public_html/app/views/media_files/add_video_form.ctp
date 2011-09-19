<div class='form'>
	<?php 
		
	echo $this->Form->create("MediaFile",array("url"=>$this->here));
	
	?>
	<fieldset>
		<legend>Add Video File</legend>
		<?php 
		
			echo $this->Form->input("file");
			echo $this->Form->input("file_video_still");
			echo $this->Form->input("name");
			echo $this->Form->input("caption");
			echo $this->Form->input("Tag.tags",array("label"=>"Tags (Multiple tags should be comma seperated)"));
			
			
				
		?>
	</fieldset>
	<fieldset>
		<legend>CDN Info</legend>
		<?php 
		echo $this->Form->input("send_to_limelight",array("type"=>"checkbox","value"=>1,"checked"=>true,"label"=>"Send To Limelight (* File will be instantly available *)"));
		echo $this->Form->input("limelight_mediavault_active",array("label"=>"Protect Content With Limelight Media Vault ** ONLY FOR ON DEMAND **"));
		echo $this->Form->input("send_to_brightcove",array("type"=>"checkbox","value"=>"1","disabled"=>true));
		
		?>
	</fieldset>
	<fieldset>
		<legend>Advertising Shit</legend>
		<?php 
		
			echo $this->Form->input("preroll_label",array("options"=>Arr::adLabels(),"empty"=>true));
			echo $this->Form->input("postroll_label",array("options"=>Arr::adLabels(),"empty"=>true));
			echo $this->Form->input("preroll_label_override");
			echo $this->Form->input("postroll_label_override");
			echo $this->Form->input("preroll_tags");
			echo $this->Form->input("postroll_tags");
		
		?>
		<div style='background-color:purple; padding:5px;'>
		**LEGACY**
		<?php 
			echo $this->Form->input("preroll",array("label"=>"Pre-roll Campaign","options"=>Arr::videoAdUrls(true),"empty"=>true));
			echo $this->Form->input("postroll",array("label"=>"Post-roll Campaign","options"=>Arr::videoAdUrls(true),"empty"=>true));
		?>
		</div>
	
	</fieldset>
<?php 

	echo $this->Form->end("Add Video");

?>

</div>