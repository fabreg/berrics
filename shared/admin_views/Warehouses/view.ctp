<div class="warehouses view">
<h2><?php  __('Warehouse');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $warehouse['Warehouse']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $warehouse['Warehouse']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $warehouse['Warehouse']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $warehouse['Warehouse']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $warehouse['Warehouse']['active']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Warehouse', true), array('action' => 'edit', $warehouse['Warehouse']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Warehouse', true), array('action' => 'delete', $warehouse['Warehouse']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $warehouse['Warehouse']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Warehouses', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Warehouse', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Canteen Inventory Records', true), array('controller' => 'canteen_inventory_records', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Canteen Inventory Record', true), array('controller' => 'canteen_inventory_records', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Canteen Shipping Records', true), array('controller' => 'canteen_shipping_records', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Canteen Shipping Record', true), array('controller' => 'canteen_shipping_records', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Canteen Inventory Records');?></h3>
	<?php if (!empty($warehouse['CanteenInventoryRecord'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Canteen Product Id'); ?></th>
		<th><?php __('Foreign Key'); ?></th>
		<th><?php __('Quantity'); ?></th>
		<th><?php __('Warehouse Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($warehouse['CanteenInventoryRecord'] as $canteenInventoryRecord):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $canteenInventoryRecord['id'];?></td>
			<td><?php echo $canteenInventoryRecord['created'];?></td>
			<td><?php echo $canteenInventoryRecord['modified'];?></td>
			<td><?php echo $canteenInventoryRecord['canteen_product_id'];?></td>
			<td><?php echo $canteenInventoryRecord['foreign_key'];?></td>
			<td><?php echo $canteenInventoryRecord['quantity'];?></td>
			<td><?php echo $canteenInventoryRecord['warehouse_id'];?></td>
			<td><?php echo $canteenInventoryRecord['name'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'canteen_inventory_records', 'action' => 'view', $canteenInventoryRecord['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'canteen_inventory_records', 'action' => 'edit', $canteenInventoryRecord['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'canteen_inventory_records', 'action' => 'delete', $canteenInventoryRecord['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $canteenInventoryRecord['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Canteen Inventory Record', true), array('controller' => 'canteen_inventory_records', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related Canteen Shipping Records');?></h3>
	<?php if (!empty($warehouse['CanteenShippingRecord'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Warehouse Id'); ?></th>
		<th><?php __('Canteen Order Id'); ?></th>
		<th><?php __('Carrier Name'); ?></th>
		<th><?php __('Tracking Number'); ?></th>
		<th><?php __('Shipping Status'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($warehouse['CanteenShippingRecord'] as $canteenShippingRecord):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $canteenShippingRecord['id'];?></td>
			<td><?php echo $canteenShippingRecord['created'];?></td>
			<td><?php echo $canteenShippingRecord['modified'];?></td>
			<td><?php echo $canteenShippingRecord['warehouse_id'];?></td>
			<td><?php echo $canteenShippingRecord['canteen_order_id'];?></td>
			<td><?php echo $canteenShippingRecord['carrier_name'];?></td>
			<td><?php echo $canteenShippingRecord['tracking_number'];?></td>
			<td><?php echo $canteenShippingRecord['shipping_status'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'canteen_shipping_records', 'action' => 'view', $canteenShippingRecord['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'canteen_shipping_records', 'action' => 'edit', $canteenShippingRecord['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'canteen_shipping_records', 'action' => 'delete', $canteenShippingRecord['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $canteenShippingRecord['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Canteen Shipping Record', true), array('controller' => 'canteen_shipping_records', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
