<div class="warehouses form">
<?php echo $this->Form->create('Warehouse');?>
	<fieldset>
		<legend><?php __('Edit Warehouse'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('active');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Warehouse.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Warehouse.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Warehouses', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Canteen Inventory Records', true), array('controller' => 'canteen_inventory_records', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Canteen Inventory Record', true), array('controller' => 'canteen_inventory_records', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Canteen Shipping Records', true), array('controller' => 'canteen_shipping_records', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Canteen Shipping Record', true), array('controller' => 'canteen_shipping_records', 'action' => 'add')); ?> </li>
	</ul>
</div>