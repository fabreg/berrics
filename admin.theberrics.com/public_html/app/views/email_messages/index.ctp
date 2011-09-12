<div class="emailMessages index">
	<h2><?php __('Email Messages');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('sent_date');?></th>
			<th><?php echo $this->Paginator->sort('to');?></th>
			<th><?php echo $this->Paginator->sort('cc');?></th>
			<th><?php echo $this->Paginator->sort('bcc');?></th>
			<th><?php echo $this->Paginator->sort('reply_to');?></th>
			<th><?php echo $this->Paginator->sort('from');?></th>
			<th><?php echo $this->Paginator->sort('subject');?></th>
			<th><?php echo $this->Paginator->sort('template');?></th>
			<th><?php echo $this->Paginator->sort('send_as');?></th>
			<th><?php echo $this->Paginator->sort('canteen_order_id');?></th>
			<th><?php echo $this->Paginator->sort('processed');?></th>

			<th><?php echo $this->Paginator->sort('app_name');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($emailMessages as $emailMessage):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $emailMessage['EmailMessage']['id']; ?>&nbsp;</td>
		<td><?php echo $emailMessage['EmailMessage']['created']; ?>&nbsp;</td>
		<td><?php echo $emailMessage['EmailMessage']['modified']; ?>&nbsp;</td>
		<td><?php echo $emailMessage['EmailMessage']['sent_date']; ?>&nbsp;</td>
		<td><?php echo $emailMessage['EmailMessage']['to']; ?>&nbsp;</td>
		<td><?php echo $emailMessage['EmailMessage']['cc']; ?>&nbsp;</td>
		<td><?php echo $emailMessage['EmailMessage']['bcc']; ?>&nbsp;</td>
		<td><?php echo $emailMessage['EmailMessage']['reply_to']; ?>&nbsp;</td>
		<td><?php echo $emailMessage['EmailMessage']['from']; ?>&nbsp;</td>
		<td><?php echo $emailMessage['EmailMessage']['subject']; ?>&nbsp;</td>
		<td><?php echo $emailMessage['EmailMessage']['template']; ?>&nbsp;</td>
		<td><?php echo $emailMessage['EmailMessage']['send_as']; ?>&nbsp;</td>
		<td><?php echo $emailMessage['EmailMessage']['canteen_order_id']; ?>&nbsp;</td>
		<td><?php echo $emailMessage['EmailMessage']['processed']; ?>&nbsp;</td>
		<td><?php echo $emailMessage['EmailMessage']['app_name']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $emailMessage['EmailMessage']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $emailMessage['EmailMessage']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $emailMessage['EmailMessage']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $emailMessage['EmailMessage']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Email Message', true), array('action' => 'add')); ?></li>
	</ul>
</div>