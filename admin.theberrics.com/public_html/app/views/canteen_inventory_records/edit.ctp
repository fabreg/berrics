<div class="canteenInventoryRecords form">
<?php echo $this->Form->create('CanteenInventoryRecord');?>
	<fieldset>
		<legend><?php __('Edit Canteen Inventory Record'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('canteen_product_id');
		echo $this->Form->input('foreign_key');
		echo $this->Form->input('quantity');
		echo $this->Form->input('warehouse_id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('CanteenInventoryRecord.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('CanteenInventoryRecord.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Canteen Inventory Records', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Warehouses', true), array('controller' => 'warehouses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Warehouse', true), array('controller' => 'warehouses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Canteen Product Inventories', true), array('controller' => 'canteen_product_inventories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Canteen Product Inventory', true), array('controller' => 'canteen_product_inventories', 'action' => 'add')); ?> </li>
	</ul>
</div>