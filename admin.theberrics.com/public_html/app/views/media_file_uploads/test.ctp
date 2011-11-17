<div class='form'>
<?php 

	echo $this->Form->create("MediaFileUpload",array("enctype"=>"multipart/form-data","url"=>$this->here));
	echo $this->Form->input("test",array("type"=>"file"));
	echo $this->Form->end("Test");

?>
</div>