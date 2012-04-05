<div class="canteenInventoryRecords form">
<?php echo $this->Form->create('CanteenInventoryRecord');?>
	<fieldset>
		<legend><?php __('Add Canteen Inventory Record'); ?></legend>
	<?php
		
		echo $this->Form->input('warehouse_id');
		echo $this->Form->input('name',array("label"=>"Name (be descriptive)"));
		echo $this->Form->input('foreign_key',array("label"=>"Item Number"));
		echo $this->Form->input('quantity');
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
