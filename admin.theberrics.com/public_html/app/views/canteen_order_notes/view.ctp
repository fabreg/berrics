<div class="canteenOrderNotes view">
<h2><?php  __('Canteen Order Note');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenOrderNote['CanteenOrderNote']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenOrderNote['CanteenOrderNote']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenOrderNote['CanteenOrderNote']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenOrderNote['CanteenOrderNote']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Message'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenOrderNote['CanteenOrderNote']['message']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($canteenOrderNote['User']['title'], array('controller' => 'users', 'action' => 'view', $canteenOrderNote['User']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Hidden'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenOrderNote['CanteenOrderNote']['hidden']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Feedback Required'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenOrderNote['CanteenOrderNote']['feedback_required']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Parent Canteen Order Note'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($canteenOrderNote['ParentCanteenOrderNote']['name'], array('controller' => 'canteen_order_notes', 'action' => 'view', $canteenOrderNote['ParentCanteenOrderNote']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Canteen Order'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($canteenOrderNote['CanteenOrder']['id'], array('controller' => 'canteen_orders', 'action' => 'view', $canteenOrderNote['CanteenOrder']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Customer Reply'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenOrderNote['CanteenOrderNote']['customer_reply']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Note Status'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenOrderNote['CanteenOrderNote']['note_status']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Canteen Order Note', true), array('action' => 'edit', $canteenOrderNote['CanteenOrderNote']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Canteen Order Note', true), array('action' => 'delete', $canteenOrderNote['CanteenOrderNote']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $canteenOrderNote['CanteenOrderNote']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Canteen Order Notes', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Canteen Order Note', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Canteen Order Notes', true), array('controller' => 'canteen_order_notes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Parent Canteen Order Note', true), array('controller' => 'canteen_order_notes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Canteen Orders', true), array('controller' => 'canteen_orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Canteen Order', true), array('controller' => 'canteen_orders', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Canteen Order Notes');?></h3>
	<?php if (!empty($canteenOrderNote['ChildCanteenOrderNote'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Message'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Hidden'); ?></th>
		<th><?php __('Feedback Required'); ?></th>
		<th><?php __('Parent Id'); ?></th>
		<th><?php __('Canteen Order Id'); ?></th>
		<th><?php __('Customer Reply'); ?></th>
		<th><?php __('Note Status'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
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
				<?php echo $this->Html->link(__('View', true), array('controller' => 'canteen_order_notes', 'action' => 'view', $childCanteenOrderNote['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'canteen_order_notes', 'action' => 'edit', $childCanteenOrderNote['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'canteen_order_notes', 'action' => 'delete', $childCanteenOrderNote['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $childCanteenOrderNote['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Child Canteen Order Note', true), array('controller' => 'canteen_order_notes', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
