<script>
	
jQuery(document).ready(function($) {
	

	$("#UnifiedStoreMediaItemForm").ajaxForm({

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


	$("#UnifiedStoreMediaItemImageFile").change(function() { 

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
<style>
		
#prog-bar {

	display:none;


}


</style>
<?php 

echo $this->Form->create('UnifiedStoreMediaItem',array(
	"id"=>'UnifiedStoreMediaItemForm',
	"url"=>$this->request->here,
	"class"=>"modal-form form-horizontal",
	"enctype"=>"multipart/form-data"
));

 ?>
<div class="modal-header">
	<h4>Add New Image</h4>
</div>
<div class="modal-body">
	<div class="row-fluid">
		<div class="span12">
			<div class="well well-small">
				Valid Image Types Are: JPEG, JPG, GIF &amp; PNG
			</div>
			<?php 
				echo $this->Form->input("unfied_store_id",array("type"=>"hidden"));
				echo $this->Form->input("image_file",array("type"=>"file"));
				echo $this->Form->input("caption");
			 ?>
		</div>
	</div>
	<div class="row-fluid" id='prog-row'>
		<div class="span12">
			<div class='progress progress-striped active'>
				<div class='bar' id='progress-bar'></div>
			</div>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button class="btn btn-primary" id='submit-button'>
		Upload Image
	</button>
	<button class="btn btn-danger" data-dismiss='modal'>
		Cancel
	</button>
</div>
<?php echo $this->Form->end(); ?>