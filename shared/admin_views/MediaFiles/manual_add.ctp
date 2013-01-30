<div class='form'>
<fieldset>
	<legend>Manually Add Media File</legend>
	<?php 
	
		echo $this->Form->create("MediaFile",array("url"=>$this->request->here));
		echo $this->Form->input("media_type",array("options"=>MediaFile::mediaFileTypes()));
		echo $this->Form->input("name");
		echo $this->Form->input("tags");
		echo $this->Form->input("brightcove_id",array("type"=>"text"));
		echo $this->Form->end("Add File");
	?>
</fieldset>
</div>