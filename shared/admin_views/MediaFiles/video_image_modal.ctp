<script>
$(document).ready(function() { 


	$("#image-form").ajaxForm({


		'success':function(d) {

			document.location.reload(true);
			
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

	
	$("#MediaFileImageFile").change(function() { 

		var file = $(this).prop('files')[0];
		var submit  = $("#submit-button");
		var valid = ["image/jpg","image/jpeg","image/gif","image/png"];

		var is_valid = ($.inArray(file.type,valid))+1;
		
		console.log(file);

		if(is_valid) {

			submit.attr("disabled",false);
			
		} else {

			
			$(this).val('');

			alert("Please choose a valid image");

			submit.attr("disabled",true);
		}

	});

	
});
</script>
<?php 

	$url = array(
			"controller"=>"media_files",
			"action"=>"handle_video_image_modal"
	);

	echo $this->Form->create("MediaFile",array("enctype"=>"multipart/form-data","class"=>"modal-form","id"=>"image-form","url"=>$url));
	echo $this->Form->input("id");
?>
<div class='modal-header'>
	<h4>Video Image</h4>
</div>
<div class='modal-body'>
	<div class='row-fluid'>
		<h5><?php echo $this->request->data['MediaFile']['name']; ?></h5>
	</div>
	<?php if(!empty($this->request->data['MediaFile']['file_video_still'])): ?>
	<div class='row-fluid'>
		<div><strong>Current Image:</strong></div>
		<?php echo $this->Media->mediaThumb(array(
					"MediaFile"=>$this->request->data['MediaFile'],
					"h"=>"80"
				)); ?>
	</div>
	<?php endif; ?>
	<div class='row-fluid'>
		<?php echo $this->Form->input("image_file",array("type"=>"file")); ?>
	</div>
	<div class='row-fluid'>
		<div>
			<span id='progress' class='label label-important'>Valid files are: jpg, jpeg, gif, png</span>
		</div>
		<div class='progress progress-striped active'>
			<div class='bar' id='progress-bar'></div>	
		</div>
	</div>
</div>
<div class='modal-footer'>
	<button type='submit' class='btn btn-primary' disabled='disabled' id='submit-button'>Update Image</button>
	<button class='btn btn-danger' type='button' data-dismiss='modal'>Close Window</button>
</div>
<?php echo $this->Form->end(); ?>