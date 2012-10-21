<div class="canteenOrderNotes view">
<h2><?php echo __('Canteen Order Note');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenOrderNote['CanteenOrderNote']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenOrderNote['CanteenOrderNote']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenOrderNote['CanteenOrderNote']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenOrderNote['CanteenOrderNote']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Message'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenOrderNote['CanteenOrderNote']['message']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Admin->link($canteenOrderNote['User']['title'], array('controller' => 'users', 'action' => 'view', $canteenOrderNote['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Hidden'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenOrderNote['CanteenOrderNote']['hidden']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Feedback Required'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenOrderNote['CanteenOrderNote']['feedback_required']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Parent Canteen Order Note'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Admin->link($canteenOrderNote['ParentCanteenOrderNote']['name'], array('controller' => 'canteen_order_notes', 'action' => 'view', $canteenOrderNote['ParentCanteenOrderNote']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Canteen Order'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Admin->link($canteenOrderNote['CanteenOrder']['id'], array('controller' => 'canteen_orders', 'action' => 'view', $canteenOrderNote['CanteenOrder']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Customer Reply'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenOrderNote['CanteenOrderNote']['customer_reply']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Note Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenOrderNote['CanteenOrderNote']['note_status']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Admin->link(__('Edit Canteen Order Note'), array('action' => 'edit', $canteenOrderNote['CanteenOrderNote']['id'])); ?> </li>
		<li><?php echo $this->Admin->link(__('Delete Canteen Order Note'), array('action' => 'delete', $canteenOrderNote['CanteenOrderNote']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $canteenOrderNote['CanteenOrderNote']['id'])); ?> </li>
		<li><?php echo $this->Admin->link(__('List Canteen Order Notes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Canteen Order Note'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Canteen Order Notes'), array('controller' => 'canteen_order_notes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Parent Canteen Order Note'), array('controller' => 'canteen_order_notes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Canteen Orders'), array('controller' => 'canteen_orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Canteen Order'), array('controller' => 'canteen_orders', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Canteen Order Notes');?></h3>
	<?php if (!empty($canteenOrderNote['ChildCanteenOrderNote'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Message'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Hidden'); ?></th>
		<th><?php echo __('Feedback Required'); ?></th>
		<th><?php echo __('Parent Id'); ?></th>
		<th><?php echo __('Canteen Order Id'); ?></th>
		<th><?php echo __('Customer Reply'); ?></th>
		<th><?php echo __('Note Status'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($canteenOrderNote['ChildCanteenOrderNote'] as $childCanteenOrderNote):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $childCanteenOrderNote['id'];?></td>
			<td><?php echo $childCanteenOrderNote['created'];?></td>
			<td><?php echo $childCanteenOrderNote['modified'];?></td>
			<td><?php echo $childCanteenOrderNote['name'];?></td>
			<td><?php echo $childCanteenOrderNote['message'];?></td>
			<td><?php echo $childCanteenOrderNote['user_id'];?></td>
			<td><?php echo $childCanteenOrderNote['hidden'];?></td>
			<td><?php echo $childCanteenOrderNote['feedback_required'];?></td>
			<td><?php echo $childCanteenOrderNote['parent_id'];?></td>
			<td><?php echo $childCanteenOrderNote['canteen_order_id'];?></td>
			<td><?php echo $childCanteenOrderNote['customer_reply'];?></td>
			<td><?php echo $childCanteenOrderNote['note_status'];?></td>
			<td class="actions">
				<?php echo $this->Admin->link(__('View'), array('controller' => 'canteen_order_notes', 'action' => 'view', $childCanteenOrderNote['id'])); ?>
				<?php echo $this->Admin->link(__('Edit'), array('controller' => 'canteen_order_notes', 'action' => 'edit', $childCanteenOrderNote['id'])); ?>
				<?php echo $this->Admin->link(__('Delete'), array('controller' => 'canteen_order_notes', 'action' => 'delete', $childCanteenOrderNote['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $childCanteenOrderNote['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Admin->link(__('New Child Canteen Order Note'), array('controller' => 'canteen_order_notes', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
