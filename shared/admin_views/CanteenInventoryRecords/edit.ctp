<div class="canteenInventoryRecords form">
<?php echo $this->Form->create('CanteenInventoryRecord');?>
	<fieldset>
		<legend><?php echo __('Edit Canteen Inventory Record'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('canteen_product_id');
		echo $this->Form->input('foreign_key');
		echo $this->Form->input('quantity');
		echo $this->Form->input('warehouse_id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $this->Form->value('CanteenInventoryRecord.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('CanteenInventoryRecord.id'))); ?></li>
		<li><?php echo $this->Admin->link(__('List Canteen Inventory Records'), array('action' => 'index'));?></li>
		<li><?php echo $this->Admin->link(__('List Warehouses'), array('controller' => 'warehouses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Warehouse'), array('controller' => 'warehouses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Canteen Product Inventories'), array('controller' => 'canteen_product_inventories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Canteen Product Inventory'), array('controller' => 'canteen_product_inventories', 'action' => 'add')); ?> </li>
	</ul>
</div>