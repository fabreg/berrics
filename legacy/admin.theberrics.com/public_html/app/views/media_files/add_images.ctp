<?php

//include Javascript
$this->Html->script(array("swfupload/swfupload","jquery.swfupload"),array("inline"=>false));


$num_images = array();




?>
<script>

$(document).ready(function() { 

	

	 $('#image-field').swfupload({
	        // Backend Settings
	        upload_url: "/media_files/handle_image_upload/<?php echo $this->Session->id(); ?>", 
	        
	        // File Upload Settings
	        file_size_limit : "102400", // 100MB
	        file_types : "*.jpg;*.png;*.gif;*.jpeg;*.zip",
	        file_types_description : "All Files",
	        file_upload_limit : "1",
	        file_queue_limit : "0",
	    
	        // Button Settings
	        button_image_url : "/img/select-images.png", // Relative to the SWF file
	        button_placeholder_id : "image-upload-button",
	        button_width: 135,
	        button_height: 22,
	        
	        // Flash Settings
	        flash_url : "/js/swfupload/swfupload.swf"
	        
	    });
	    
	    
	    // assign our event handlers
	    $('#image-field')
	        .bind('fileQueued', function(event, file){
	            // start the upload once a file is queued
	           
	            $(this).swfupload('startUpload');
	        })
	        .bind('uploadComplete', function(event, file){


				//alert(serverData);

	            //alert('Upload completed - '+file.name+'!');
	            // start the upload (if more queued) once an upload is complete
	            //$(this).swfupload('startUpload');
	        })
	        .bind("uploadSuccess",function(e,f,d) { 

	        	$("#image-field").hide();

	        	$("#upload-results").html(d);

	        	$("#progress").html("Upload Completed");
				
		     })
		     .bind('uploadStart',function(f) { 
			
				//hide the upload button
				

			 })
			 .bind('uploadProgress',function(e,f,bl) { 


				$("#progress").html("Progress:"+Math.round(bl/1024)+" kb / "+Math.round(f['size']/1024)+ "kb");
				
				 
			 });

	 
});

</script>
<div class='form'>
	<div style='padding:10px;'>
		To upload multiple images, add the images to a zip file then upload.
	</div>
	<div id='num-images'>
		<?php 
		
			echo $this->Form->create("AddImages",array("url"=>$this->here,"enctype"=>"multipart/form-data"));
		
		?>
		<fieldset>
			<legend>Upload Image(s)</legend>
			<div id='image-field'>
			<?php 
			
				//echo $this->Form->file("image_upload");

			?>
				<span id='image-upload-button'></span>
			</div>
			<div id='progress'>
			
			</div>
		</fieldset>
		<?php 
		
			echo $this->Form->end();
		
		?>
	</div>
	<div id='upload-results'>
	
	</div>
</div>
