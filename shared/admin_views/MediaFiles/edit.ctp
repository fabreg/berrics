<?php 

//reduce tags in to comma seperated string

App::import("Vendor","LLMediaVault",array("file"=>"LLMediaVault.php"));

$tag_array = Set::extract("/Tag/name",$this->request->data);

$tag_str = implode(",",$tag_array);

pr($this->request->data);

$types = MediaFile::mediaFileTypes();

?>
<div class="mediaFiles form">
<?php echo $this->Form->create('MediaFile');?>
	<fieldset>
 		<legend><?php echo __('Edit Media File'); ?></legend>
	<?php
		echo $this->Form->input("postback",array("type"=>"hidden","value"=>$this->request->params['pass'][1]));
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('media_type',array("options"=>$types));
		echo $this->Form->input("url",array("label"=>"Url ( USE HTTP:// )"));
		echo $this->Form->input('tags',array("type"=>"text","label"=>"Tags ( Comma seperated )","value"=>$tag_str));
		echo $this->Form->input("caption");

		echo $this->Form->input("User",array("multiple"=>true));
		echo "<div>";
			echo $this->Admin->link("Preview Video","http://www.theberrics.com/dailyopspost.php?postid=".$this->request->data['MediaFile']['legacy_entry'],array("target"=>"_blank"));
		echo "</div>";
	?>
	</fieldset>
	<fieldset>
		<legend>Limelight Migration</legend>
		<?php 
		
			echo $this->Form->input("limelight_transfer_status");
			echo $this->Form->input("limelight_active");
			echo $this->Form->input("limelight_file");
			
			
		?>
		<div style='padding-top:10px; font-style:italic;'>
			<?php if($this->request->data['MediaFile']['limelight_mediavault_active']==1): ?>

				<?php echo MediaFile::returnSecureUrl($this->request->data['MediaFile']); ?>

			<?php else: ?>
				http://berrics.vo.llnwd.net/o45/<?php echo $this->request->data['MediaFile']['limelight_file']; ?>
			<?php endif; ?>
			
		</div>
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
<?php echo $this->Form->end(__('Submit'));?>
</div>
