<div class='form'>
<fieldset>
	<legend>Update Limelight Video File: <?php echo $this->request->data['MediaFile']['name']; ?></legend>
	<?php 

	echo $this->Form->create("MediaFile",array("url"=>$this->request->here,"enctype"=>"multipart/form-data"));
	echo $this->Form->input("new_file",array("type"=>"file"));
	echo $this->Form->input("id");
	
	if(isset($this->request->params['pass'][1])) {

		echo $this->Form->input("postback",array("type"=>"hidden","value"=>$this->request->params['pass'][1]));
	
	}
	
	echo $this->Form->end("Update Video");
	
?>
</fieldset>

</div>