<div class="canteenInventoryRecords form">
<?php echo $this->Form->create('CanteenInventoryRecord',array("url"=>$this->request->here));?>
	<fieldset>
		<legend><?php echo __('Add Canteen Inventory Record'); ?></legend>
	<?php
		
		echo $this->Form->input('warehouse_id');
		echo $this->Form->input('name',array("label"=>"Name (be descriptive)"));
		echo $this->Form->input('foreign_key',array("label"=>"Item Number"));
		if(isset($this->request->params['named']['canteen_product_id'])) {
			
			echo $this->Form->input("canteen_product_id",array("value"=>$this->request->params['named']['canteen_product_id'],"type"=>"hidden"));
			
		}
		echo $this->Form->input('quantity');
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
