<script>
	jQuery(document).ready(function($) {
			
		$("#UnifiedStoreEmployeeForm").ajaxForm({

			success:function(d) {

				$("#add-new-employee").html(d);


			},
			beforeSubmit:function() {

				$("#submit-btn").attr({
	
					"disabled":"disabled"

				});				

				return true;

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
	<h4><?php echo (preg_match('/(add)/',$this->request->params['action'])) ? "Add New":"Edit" ?> Employee</h4>
</div>
<div class="modal-body">
<div class="row-fluid">
	<?php echo $this->Session->flash(); ?>
	<?php 
	if(isset($this->request->data['UnifiedStoreEmployee']['id'])) {

		echo $this->Form->input("id");

	}
	echo $this->Form->input("unified_store_id",array("type"=>"hidden"));
	echo $this->Form->input("name");
	echo $this->Form->input("title",array("options"=>UnifiedStoreEmployee::titles(),"empty"=>true));
	echo $this->Form->input("email");
	echo $this->Form->input("facebook_url");
	echo $this->Form->input("twitter_handle");
	echo $this->Form->input("instagram_handle");
	echo $this->Form->input("image_file",array("type"=>"file"));

 ?>
</div>
</div>
<div class="modal-footer">
		<button class="btn btn-primary" id='submit-btn'>
			<?php echo (isset($this->request->data['UnifiedStoreEmployee']['id'])) ? "Edit":"Add New"; ?> Employee
		</button>
		<button class="btn btn-danger" type='button' data-dismiss='modal' >
			Cancel
		</button>
</div>
<?php echo $this->Form->end(); ?>
<script>
	initBootstrap();
</script>