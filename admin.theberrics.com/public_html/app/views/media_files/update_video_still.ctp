<div class='form' style='width:60%; margin:auto;'>

	<fieldset>
		<legend>Update Video Still</legend>
	
	<?php 
	
		echo $media->mediaThumb(array(
		
			"MediaFile"=>$this->data['MediaFile'],
			"h"=>200,
			"w"=>200
		
		));
	
	?>
	<?php 
	
		echo $this->Form->create("MediaFile",array("url"=>$this->here,"enctype"=>"multipart/form-data"));
		
		echo $this->Form->input("file_video_still",array("type"=>"file","label"=>"Image File (JPG,PNG,GIF)"));
		
		echo $this->Form->input("id",array("type"=>"hidden"));
		
		echo $this->Form->input("postback",array('type'=>'hidden','value'=>$this->params['pass'][1]));
		
		echo $this->Form->end("Update");

	?>
	</fieldset>


</div>