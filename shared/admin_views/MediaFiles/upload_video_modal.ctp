<script>
$(document).ready(function() { 

	$("#upload-video-form").ajaxForm({

		dataType:"json",
		'success':function(d) {
			
			//$("#video-upload-modal").html(d);
			
			//$(document).trigger('videoFileUploadComplete',d);
			
			document.location.href = "/media_files/inspect/"+d.MediaFile.id;
			
		},
		uploadProgress: function(event, position, total, percentComplete) {
	       
			$("#submit-button").attr("disabled",true);
			
			if(percentComplete<100) {
				 var percentVal = percentComplete + '%';
				$("#progress").html(percentVal);
		        $("#progress-bar").css({
					width:percentVal
			    });
				
			} else {
			
				$("#progress").html("Processing file....");
				 $("#progress-bar").css({
						width:"100%"
				    });
			}
			
	        
	    }
		

	});

	$(document).bind('videoFileUploadComplete',function(e,d) { 

		$('body').prepend(d);
		
	});

	$("#MediaFileVideoFile").change(function(e) { 

		var file = $(this).prop('files')[0];
		var submit  = $("#submit-button");
		console.log(file);

		if(file.type!='video/mp4') {

			$(this).val('');

			alert("File must be an mp4");

			submit.attr("disabled",true);
			
		} else {

			submit.attr("disabled",false);

		}

	});

	$("#submit-button").attr("disabled",true);

	
});
</script>
<?php 
	$url = array(
				"controller"=>"media_files",
				"action"=>"handle_upload_video_modal"
			);
	
	$this->Form->formSpan = 'span9';
	
	echo $this->Form->create("MediaFile",array("class"=>"modal-form","id"=>"upload-video-form","url"=>$url));
	
	if(isset($this->request->data['MediaFile']['id'])) {
		
		echo $this->Form->input("id");
		
	}
	
?>
<div class='modal-header'>
	<h4><?php echo (isset($this->request->data['MediaFile']['id'])) ? "Update":"Create"; ?> Video File</h4>
</div>
<div class='modal-body'>
		<?php 
			if(isset($this->request->data['MediaFile']['id'])):
		?>
		<div class='alert alert-error'>
			* This will overrwrite the original file *
		</div>
		<?php 
			endif;
		?>
		<div class='row-fluid'>
			
			<?php echo $this->Form->input("name"); ?>
			<?php echo $this->Form->input("website_id",array("options"=>$websites)); ?>
			<?php echo $this->Form->input("video_file",array("type"=>"file","label"=>"Select a Video File")); ?>
			
		</div>
		<div class='row-fluid' >
			<span class='label label-important' id='progress'>File must be an MP4</span>
		</div>
		<div class='row-fluid'>
			<div class='progress progress-striped active'>
				<div class='bar' id='progress-bar'></div>
			</div>
		</div>
	
</div>
<div class='modal-footer'>
	<button type='submit' class='btn btn-primary' id='submit-button'>Upload Video</button>
	<button type='button' class='btn btn-danger' data-dismiss='modal'>Close Window</button>
</div>
<?php 

	echo $this->Form->end();

?>