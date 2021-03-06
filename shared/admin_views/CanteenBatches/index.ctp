<div class="canteenBatches index">
	<h2><?php echo __('Canteen Batches');?></h2>
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
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($canteenBatches as $canteenBatch):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $canteenBatch['CanteenBatch']['id']; ?>&nbsp;</td>
		<td><?php echo $this->Time->niceShort($canteenBatch['CanteenBatch']['created']); ?>&nbsp;</td>
		<td><?php echo $this->Time->niceShort($canteenBatch['CanteenBatch']['modified']); ?>&nbsp;</td>
		<td align='center'>
			<?php echo $canteenBatch['User']['first_name']." ".$canteenBatch['User']['last_name']; ?>
		</td>
		<td><?php echo $canteenBatch['CanteenBatch']['name']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Admin->link(__('View'), array('action' => 'view', $canteenBatch['CanteenBatch']['id'])); ?>
			<?php echo $this->Admin->link(__('Edit'), array('action' => 'edit', $canteenBatch['CanteenBatch']['id'])); ?>
			<?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $canteenBatch['CanteenBatch']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $canteenBatch['CanteenBatch']['id'])); ?>
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