<div class="canteenInventoryRecords view">
<h2><?php  __('Canteen Inventory Record');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenInventoryRecord['CanteenInventoryRecord']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenInventoryRecord['CanteenInventoryRecord']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenInventoryRecord['CanteenInventoryRecord']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Canteen Product Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenInventoryRecord['CanteenInventoryRecord']['canteen_product_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Foreign Key'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenInventoryRecord['CanteenInventoryRecord']['foreign_key']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Quantity'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenInventoryRecord['CanteenInventoryRecord']['quantity']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Warehouse'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($canteenInventoryRecord['Warehouse']['name'], array('controller' => 'warehouses', 'action' => 'view', $canteenInventoryRecord['Warehouse']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenInventoryRecord['CanteenInventoryRecord']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Canteen Inventory Record', true), array('action' => 'edit', $canteenInventoryRecord['CanteenInventoryRecord']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Canteen Inventory Record', true), array('action' => 'delete', $canteenInventoryRecord['CanteenInventoryRecord']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $canteenInventoryRecord['CanteenInventoryRecord']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Canteen Inventory Records', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Canteen Inventory Record', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Warehouses', true), array('controller' => 'warehouses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Warehouse', true), array('controller' => 'warehouses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Canteen Product Inventories', true), array('controller' => 'canteen_product_inventories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Canteen Product Inventory', true), array('controller' => 'canteen_product_inventories', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Canteen Product Inventories');?></h3>
	<?php if (!empty($canteenInventoryRecord['CanteenProductInventory'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Canteen Product Id'); ?></th>
		<th><?php __('Canteen Inventory Record Id'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($canteenInventoryRecord['CanteenProductInventory'] as $canteenProductInventory):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $canteenProductInventory['id'];?></td>
			<td><?php echo $canteenProductInventory['created'];?></td>
			<td><?php echo $canteenProductInventory['canteen_product_id'];?></td>
			<td><?php echo $canteenProductInventory['canteen_inventory_record_id'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'canteen_product_inventories', 'action' => 'view', $canteenProductInventory['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'canteen_product_inventories', 'action' => 'edit', $canteenProductInventory['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'canteen_product_inventories', 'action' => 'delete', $canteenProductInventory['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $canteenProductInventory['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Canteen Product Inventory', true), array('controller' => 'canteen_product_inventories', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
