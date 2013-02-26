<script>
jQuery(document).ready(function($) {
	
	$("#UnifiedStoreHourForm").ajaxForm({

		success:function(d) { 

			$("#add-store-hour").html(d);

		}

	});
	
	$("#UnifiedStoreHourCustomDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});

});
</script>
<style>
#add-store-hour select {

	width:30%;

}
</style>
<?php 
echo $this->Form->create('UnifiedStoreHour',array(
	"id"=>'UnifiedStoreHourForm',
	"url"=>$this->request->here,
	"class"=>"modal-form"
));
 ?>
<div class="modal-header">
	<h5>Custom Store Hour Entry</h5>
</div>
<div class="modal-body">
	<div class="row-fluid">
		<div class="span12">
			<?php
				echo $this->Form->input("unified_store_id",array("type"=>"hidden","value"=>$store_id));
				echo $this->Form->input("open");
				echo $this->Form->input("custom_label");
				echo $this->Form->input("custom_date",array("type"=>"text"));
				echo $this->Form->input("hours_open");
				echo $this->Form->input("hours_close");
			 ?>
		</div>
	</div>
</div>
<div class="modal-footer">
	<button class="btn btn-primary">Add Custom Label</button>
	<button class="btn btn-danger" type='button' data-dismiss='modal'>Cancel</button>
</div>
<?php echo $this->Form->end(); ?>