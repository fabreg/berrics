<div class="canteenInventoryRecords index">
	<h2><?php __('Canteen Inventory Records');?></h2>
	<div class='form'>
		<fieldset>
			<legend>Search</legend>
			<?php 
				echo $this->Form->create("CanteenInventoryRecord",array("url"=>"/canteen_inventory_records/search"));
				echo $this->Form->input("name");
				echo $this->Form->input("foreign_key");
				echo $this->Form->end("Search")
			?>
		</fieldset>
	</div>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('foreign_key');?></th>
			<th><?php echo $this->Paginator->sort('quantity');?></th>
			<th><?php echo $this->Paginator->sort('allocated');?></th>
			<th><?php echo $this->Paginator->sort('warehouse_id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($canteenInventoryRecords as $canteenInventoryRecord):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $canteenInventoryRecord['CanteenInventoryRecord']['id']; ?>&nbsp;</td>
		<td><?php echo $canteenInventoryRecord['CanteenInventoryRecord']['created']; ?>&nbsp;</td>
		<td><?php echo $canteenInventoryRecord['CanteenInventoryRecord']['modified']; ?>&nbsp;</td>
		<td><?php echo $canteenInventoryRecord['CanteenInventoryRecord']['foreign_key']; ?>&nbsp;</td>
		<td><?php echo $canteenInventoryRecord['CanteenInventoryRecord']['quantity']; ?>&nbsp;</td>
		<td><?php echo $canteenInventoryRecord['CanteenInventoryRecord']['allocated']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($canteenInventoryRecord['Warehouse']['name'], array('controller' => 'warehouses', 'action' => 'view', $canteenInventoryRecord['Warehouse']['id'])); ?>
		</td>
		<td><?php echo $canteenInventoryRecord['CanteenInventoryRecord']['name']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $canteenInventoryRecord['CanteenInventoryRecord']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $canteenInventoryRecord['CanteenInventoryRecord']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $canteenInventoryRecord['CanteenInventoryRecord']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $canteenInventoryRecord['CanteenInventoryRecord']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Canteen Inventory Record', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Warehouses', true), array('controller' => 'warehouses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Warehouse', true), array('controller' => 'warehouses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Canteen Product Inventories', true), array('controller' => 'canteen_product_inventories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Canteen Product Inventory', true), array('controller' => 'canteen_product_inventories', 'action' => 'add')); ?> </li>
	</ul>
</div>