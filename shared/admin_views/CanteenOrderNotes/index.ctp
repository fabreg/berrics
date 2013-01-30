<div class="canteenOrderNotes index">
	<h2><?php echo __('Canteen Order Notes');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('message');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('hidden');?></th>
			<th><?php echo $this->Paginator->sort('feedback_required');?></th>
			<th><?php echo $this->Paginator->sort('parent_id');?></th>
			<th><?php echo $this->Paginator->sort('canteen_order_id');?></th>
			<th><?php echo $this->Paginator->sort('customer_reply');?></th>
			<th><?php echo $this->Paginator->sort('note_status');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($canteenOrderNotes as $canteenOrderNote):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $canteenOrderNote['CanteenOrderNote']['id']; ?>&nbsp;</td>
		<td><?php echo $canteenOrderNote['CanteenOrderNote']['created']; ?>&nbsp;</td>
		<td><?php echo $canteenOrderNote['CanteenOrderNote']['modified']; ?>&nbsp;</td>
		<td><?php echo $canteenOrderNote['CanteenOrderNote']['name']; ?>&nbsp;</td>
		<td><?php echo $canteenOrderNote['CanteenOrderNote']['message']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Admin->link($canteenOrderNote['User']['title'], array('controller' => 'users', 'action' => 'view', $canteenOrderNote['User']['id'])); ?>
		</td>
		<td><?php echo $canteenOrderNote['CanteenOrderNote']['hidden']; ?>&nbsp;</td>
		<td><?php echo $canteenOrderNote['CanteenOrderNote']['feedback_required']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Admin->link($canteenOrderNote['ParentCanteenOrderNote']['name'], array('controller' => 'canteen_order_notes', 'action' => 'view', $canteenOrderNote['ParentCanteenOrderNote']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Admin->link($canteenOrderNote['CanteenOrder']['id'], array('controller' => 'canteen_orders', 'action' => 'view', $canteenOrderNote['CanteenOrder']['id'])); ?>
		</td>
		<td><?php echo $canteenOrderNote['CanteenOrderNote']['customer_reply']; ?>&nbsp;</td>
		<td><?php echo $canteenOrderNote['CanteenOrderNote']['note_status']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Admin->link(__('View'), array('action' => 'view', $canteenOrderNote['CanteenOrderNote']['id'])); ?>
			<?php echo $this->Admin->link(__('Edit'), array('action' => 'edit', $canteenOrderNote['CanteenOrderNote']['id'])); ?>
			<?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $canteenOrderNote['CanteenOrderNote']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $canteenOrderNote['CanteenOrderNote']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%')
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous'), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next') . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Admin->link(__('New Canteen Order Note'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Admin->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Canteen Order Notes'), array('controller' => 'canteen_order_notes', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Parent Canteen Order Note'), array('controller' => 'canteen_order_notes', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Canteen Orders'), array('controller' => 'canteen_orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Canteen Order'), array('controller' => 'canteen_orders', 'action' => 'add')); ?> </li>
	</ul>
</div>