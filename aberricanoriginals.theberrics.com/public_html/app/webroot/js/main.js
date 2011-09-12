$(document).ready(function() { 
	
	$('#video-upload').swfupload({
        // Backend Settings
        upload_url: "/home/handle_upload/"+sid,    // Relative to the SWF file (or you can use absolute paths)
        
        // File Upload Settings
        file_size_limit : "102400", // 100MB
        file_types : "*.mov;*.mp4",
        file_types_description : "Video",
        file_upload_limit : "1",
        file_queue_limit : "0",
    
        // Button Settings
        button_image_url : "/img/upload-button.jpg", // Relative to the SWF file
        button_placeholder_id : "video-upload-button",
        button_width: 228,
        button_height: 37,
        
        // Flash Settings
        flash_url : "/js/swfupload/swfupload.swf"
        
    });
	
	$('#video-upload')
    .bind('fileQueued', function(event, file){
        // start the upload once a file is queued
        $(this).swfupload('startUpload');
       
    })
    .bind('uploadComplete', function(event, file){

    }) 
    .bind('uploadProgress',function(e,f,bl) { 

		$("#video-upload-progress").html("Progress: "+Math.round(bl/1024)+" kb / "+Math.round(f['size']/1024)+ " kb");
		 
	 }) .bind("uploadSuccess",function(e,f,d) { 

		$("#video-upload-button").hide();
     	$("#video-upload-progress").html(d);

	 });

	
	
	
});