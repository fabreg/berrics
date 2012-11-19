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

	
	$(".modal-body input[type=file]").change(function() { 

		validateImages();

	});

	
});

function validateImages() {
	

	var valid = false;

	var submit  = $("#submit-button");

	var empty = 0;

	var inputs = $(".modal-body input[type=file]").get();

	for(var a in inputs) {
		
		var input = $(inputs[a]);

		if(input.val().length>0) {

			var file = input.prop('files')[0];
			var validFile = ["image/jpg","image/jpeg","image/gif","image/png"];
			var is_valid = ($.inArray(file.type,validFile))+1;

			if(!is_valid) {

				submit.attr("disabled",true);
				input.val("");
				alert("Invalid Image Format");
				return validateImages();
				break;
			}

		} else {

			empty++;
			console.log("empty:"+empty);
			console.log("name:"+input.attr("name"));
		}	

	}

	
		


	if(empty>=3) {

		submit.attr("disabled",true);

	} else {
		 submit.attr("disabled",false);
	 	

	}
	
	
	

}
</script>
<style>
	.modal-body input[type=file] {

		font-size: 11px;

	}
	.modal-body label {

		font-size:12px;

	}
</style>
<?php 

	$url = array(
			"controller"=>"media_files",
			"action"=>"handle_video_image_modal"
	);

	echo $this->Form->create("MediaFile",array("enctype"=>"multipart/form-data","class"=>"modal-form","id"=>"image-form","url"=>$url));
	echo $this->Form->input("id");
?>
<div class='modal-header'>
	<h4>Video Image - <?php echo $this->request->data['MediaFile']['name']; ?></h4>
</div>
<div class='modal-body'>
	<div class="row-fluid">
		<div class="span12">
			<table class='table table-bordered table-hover table-striped'>
				<tbody>
					<tr>
						<td width='60%'><?php echo $this->Form->input("image_file",array("type"=>"file","label"=>"Primary Image")); ?></td>
						<td>
							<?php if(!empty($this->request->data['MediaFile']['file_video_still'])): ?>
								<?php echo $this->Media->mediaThumb(array(
											"MediaFile"=>$this->request->data['MediaFile'],
											"h"=>"45"
										)); ?>
							<?php endif; ?>
						</td>
					</tr>
					<tr>
						<td><?php echo $this->Form->input("image_file_slim",array("type"=>"file","label"=>"Slim Image")); ?></td>
						<td></td>
					</tr>
					<tr>
						<td><?php echo $this->Form->input("image_file_large",array("type"=>"file","label"=>"Large Image")); ?></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
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