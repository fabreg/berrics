<?php 

$this->Html->script(array("swfupload/swfupload","jquery.swfupload"),array("inline"=>false));

?>
<script>

var video_file = false;
var video_still = false;

$(document).ready(function() { 

	//setup the video file
	
	 $('#video-file').swfupload({
	        // Backend Settings
	        upload_url: "/media_files/handle_video_file_upload/<?php echo $this->Session->id(); ?>", 
	        
	        // File Upload Settings
	        file_size_limit : "102400", // 100MB
	        file_types : "*.mp4",
	        file_types_description : "All Files",
	        file_upload_limit : "1",
	        file_queue_limit : "1",
	    
	        // Button Settings
	        button_image_url : "/img/video-upload.png", // Relative to the SWF file
	        button_placeholder_id : "video-file-button",
	        button_width: 135,
	        button_height: 22,
	        
	        // Flash Settings
	        flash_url : "/js/swfupload/swfupload.swf"
	        
	    });
	    
	    
	    // assign our event handlers
	    $('#video-file')
	        .bind('fileQueued', function(event, file){
	            // start the upload once a file is queued
	           
	            $(this).swfupload('startUpload');

				$("#video-file-button").hide();
	            
	        })
	        .bind('uploadComplete', function(event, file){


			
				
	        })
	        .bind("uploadSuccess",function(e,f,d) { 

	        	$("#video-file").hide();

	        	$("#video-file-results").html(d);

	        	video_file = f['name'];
	        	
				loadVideoForm(video_file,video_still);
				
		     })
		     .bind('uploadStart',function(f) { 
			
				//hide the upload button
				

			 })
			 .bind('uploadProgress',function(e,f,bl) { 


				$("#video-file-results").html("Progress:"+Math.round(bl/1024)+" kb / "+Math.round(f['size']/1024)+ "kb");
				
				 
			 });



	//setup the video still
	    $('#video-still').swfupload({
	        // Backend Settings
	        upload_url: "/media_files/handle_video_still_upload/<?php echo $this->Session->id(); ?>", 
	        
	        // File Upload Settings
	        file_size_limit : "102400", // 100MB
	        file_types : "*.jpg;*.png;*.gif;*.jpeg;*.zip",
	        file_types_description : "All Files",
	        file_upload_limit : "1",
	        file_queue_limit : "1",
	    
	        // Button Settings
	        button_image_url : "/img/select-images.png", // Relative to the SWF file
	        button_placeholder_id : "video-still-button",
	        button_width: 135,
	        button_height: 22,
	        
	        // Flash Settings
	        flash_url : "/js/swfupload/swfupload.swf"
	        
	    });
	    
	    
	    // assign our event handlers
	    $('#video-still')
	        .bind('fileQueued', function(event, file){
	            // start the upload once a file is queued
	           
	            $(this).swfupload('startUpload');

				$("#video-still-button").hide();
	            
	        })
	        .bind('uploadComplete', function(event, file){

	        	
	        	
	        })
	        .bind("uploadSuccess",function(e,f,d) { 

	        	$("#video-still").hide();

	        	$("#video-still-results").html(d);

	        	video_still = f['name'];

				loadVideoForm(video_file,video_still);
				
		     })
		     .bind('uploadStart',function(f) { 
			
				//hide the upload button
				

			 })
			 .bind('uploadProgress',function(e,f,bl) { 


				$("#video-still-results").html("Progress:"+Math.round(bl/1024)+" kb / "+Math.round(f['size']/1024)+ "kb");
				
				 
			 });


		 $("#skip-image-upload").change(function() { 


			if($(this).attr('checked')) {

				video_still = true;
				
			} else {

				video_still = false;

			}
				

		});
		
	
});


function loadVideoForm(video,still) {

	if(video != false && still != false) {

		$("#media-file-form").html("Loading ..... ").load("/media_files/add_video_form/video_file:"+escape(video_file)+"/video_still:"+escape(video_still),function() { 

			


		});
		
	}

	

	
}
</script>
<style>

.form .left {

	float:left;
	width:320px;

}


.form .right {

	float:left;
	width:540px;
}


#media-file-form-wait {

	display:none;
	
}

</style>
<div class='form'>
	
	<div style='width:750px; margin:auto;' >
		<div class='form'>
		<fieldset>
				<legend>Video File</legend>
				<div id='video-file'>
					<span id='video-file-button'></span>
				</div>
				<div id='video-file-results'>
					
				</div>
			</fieldset>
			
			<fieldset>
				<legend>Video Still</legend>
				<div id='video-still'>
					<span id='video-still-button'></span>
				</div>
				<div id='video-still-results'>
				
				</div>
				<div>
					Skip Image Upload
					<input type='checkbox' value='1' id='skip-image-upload'  />
				</div>
			</fieldset>
		</div>
		
			<div id='media-file-form'>
			
			</div>
			<div id='media-file-form-wait'>
			
			
			</div>
		<div style='clear:both;'></div>
	</div>

	
</div>