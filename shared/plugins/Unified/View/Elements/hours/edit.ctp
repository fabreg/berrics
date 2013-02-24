<?php
echo $this->Form->create('UnifiedStoreHour',array(
	"id"=>'UnifiedStoreHourForm',
	"url"=>$this->request->here
));
?>
<div class="modal-header">
	<h4>
		New Store Hours Entry
	</h4>
</div>
<div class="modal-body">
	
</div>
<div class="modal-footer">
	<button class="btn btn-primary">
		Add Store Hour Entry
	</button>
	<button class="btn btn-danger" data-dismiss='modal'>
		Close Window
	</button>
</div>
<?php echo $this->Form->end(); ?>