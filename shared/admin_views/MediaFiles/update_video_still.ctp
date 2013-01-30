<div class='form' style='width:60%; margin:auto;'>

	<fieldset>
		<legend>Update Video Still</legend>
	
	<?php 
	
		echo $media->mediaThumb(array(
		
			"MediaFile"=>$this->request->data['MediaFile'],
			"h"=>200,
			"w"=>200
		
		));
	
	?>
	<?php 
	
		echo $this->Form->create("MediaFile",array("url"=>$this->request->here,"enctype"=>"multipart/form-data"));
		
		echo $this->Form->input("file_video_still",array("type"=>"file","label"=>"Image File (JPG,PNG,GIF)"));
		
		echo $this->Form->input("id",array("type"=>"hidden"));
		
		echo $this->Form->input("postback",array('type'=>'hidden','value'=>$this->request->params['pass'][1]));
		
		echo $this->Form->end("Update");

	?>
	</fieldset>


</div>