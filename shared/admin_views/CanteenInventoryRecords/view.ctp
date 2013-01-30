<div class="canteenInventoryRecords view">
<h2><?php echo __('Canteen Inventory Record');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenInventoryRecord['CanteenInventoryRecord']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenInventoryRecord['CanteenInventoryRecord']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenInventoryRecord['CanteenInventoryRecord']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Canteen Product Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenInventoryRecord['CanteenInventoryRecord']['canteen_product_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Foreign Key'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenInventoryRecord['CanteenInventoryRecord']['foreign_key']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Quantity'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenInventoryRecord['CanteenInventoryRecord']['quantity']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Warehouse'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Admin->link($canteenInventoryRecord['Warehouse']['name'], array('controller' => 'warehouses', 'action' => 'view', $canteenInventoryRecord['Warehouse']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenInventoryRecord['CanteenInventoryRecord']['name']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Admin->link(__('Edit Canteen Inventory Record'), array('action' => 'edit', $canteenInventoryRecord['CanteenInventoryRecord']['id'])); ?> </li>
		<li><?php echo $this->Admin->link(__('Delete Canteen Inventory Record'), array('action' => 'delete', $canteenInventoryRecord['CanteenInventoryRecord']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $canteenInventoryRecord['CanteenInventoryRecord']['id'])); ?> </li>
		<li><?php echo $this->Admin->link(__('List Canteen Inventory Records'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Canteen Inventory Record'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Warehouses'), array('controller' => 'warehouses', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Warehouse'), array('controller' => 'warehouses', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Canteen Product Inventories'), array('controller' => 'canteen_product_inventories', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Canteen Product Inventory'), array('controller' => 'canteen_product_inventories', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Canteen Product Inventories');?></h3>
	<?php if (!empty($canteenInventoryRecord['CanteenProductInventory'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Canteen Product Id'); ?></th>
		<th><?php echo __('Canteen Inventory Record Id'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
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
				<?php echo $this->Admin->link(__('View'), array('controller' => 'canteen_product_inventories', 'action' => 'view', $canteenProductInventory['id'])); ?>
				<?php echo $this->Admin->link(__('Edit'), array('controller' => 'canteen_product_inventories', 'action' => 'edit', $canteenProductInventory['id'])); ?>
				<?php echo $this->Admin->link(__('Delete'), array('controller' => 'canteen_product_inventories', 'action' => 'delete', $canteenProductInventory['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $canteenProductInventory['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Admin->link(__('New Canteen Product Inventory'), array('controller' => 'canteen_product_inventories', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
