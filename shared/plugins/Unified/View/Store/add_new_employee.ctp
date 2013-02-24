<script>
	jQuery(document).ready(function($) {
			
		$("#UnifiedStoreEmployeeForm").ajaxForm({

			success:function(d) {

				$("#add-new-employee").html(d);


			}

		});
	});
</script>
<style>
	#add-new-employee,
	#add-new-employee .control-label {

		font-size:12px;

	}
	#add-new-employee .control-group {

		margin-bottom:10px;

	}
	
	#add-new-employee .control-group .help-block.error {

		margin:0;

	}

</style>
<?php
	
 //$this->Form->formSpan = 'span6';

 echo $this->Form->create('UnifiedStoreEmployee',array(
	"id"=>'UnifiedStoreEmployeeForm',
	"url"=>$this->request->here,
	"enctype"=>"multipart/form-data",
	"class"=>"modal-form form-horizontal"
)); ?>
<div class="modal-header">
	<h4>Add New Employee</h4>
</div>
<div class="modal-body">
<div class="row-fluid">
	<?php 
	echo $this->Form->input("unified_store_id",array("type"=>"hidden","value"=>$this->data->request['UnifiedStore']['id']));
	echo $this->Form->input("name");
	echo $this->Form->input("title");
	echo $this->Form->input("facebook_url");
	echo $this->Form->input("twitter_handle");
	echo $this->Form->input("instagram_handle");
	echo $this->Form->input("image_file",array("type"=>"file"));

 ?>
</div>
</div>
<div class="modal-footer">
		<button class="btn btn-primary">
			Add New Employee
		</button>
		<button class="btn btn-danger" type='button' data-dismiss='modal' >
			Cancel
		</button>
</div>
<?php echo $this->Form->end(); ?>