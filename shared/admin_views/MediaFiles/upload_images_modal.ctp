<script>
$(document).ready(function() { 


	$("#image-form").ajaxForm({


		'success':function(d) {

			document.location.href="/media_files/pending_images";
			
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
		var valid = ["image/jpg","image/jpeg","image/gif","image/png","application/zip"];

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
			"action"=>"handle_image_upload_modal"
		);

echo $this->Form->create("MediaFile",array("url"=>$url,"class"=>"modal-form","enctype"=>"multipart/form-data","id"=>"image-form"));

?>
<div class='modal-header'>
	<h4>Upload Images</h4>
</div>
<div class='modal-body'>
	<div class='row-fluid'>
		<div class='alert alert-info'>
			To upload multiple images, place them inside a zip file
		</div>
		<?php 
			echo $this->Form->input("image_file",array("type"=>"file"));
		?>
	</div>
	<div class='row-fluid' >
			<span class='label label-important' id='progress'>Valid Types Are: jpg, jpeg, gif, png, .zip</span>
		</div>
		<div class='row-fluid'>
			<div class='progress progress-striped active'>
				<div class='bar' id='progress-bar'></div>
			</div>
		</div>
	</div>
<div class='modal-footer'>
	<button type='submit' class='btn btn-primary' disabled='disabled' id='submit-button'>Upload File</button>
	<button type='button' class='btn btn-danger' data-dismiss='modal' >Close Window</button>

</div>
<?php 
echo $this->Form->end();
?>