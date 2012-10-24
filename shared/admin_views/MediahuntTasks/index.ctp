<div class="mediahuntTasks index">
	<h2><?php echo __('Mediahunt Tasks');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th><?php echo $this->Paginator->sort('mediahunt_event_id');?></th>
			<th><?php echo $this->Paginator->sort('sort_order');?></th>
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('details');?></th>
			<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($mediahuntTasks as $mediahuntTask):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $mediahuntTask['MediahuntTask']['id']; ?>&nbsp;</td>
		<td><?php echo $mediahuntTask['MediahuntTask']['created']; ?>&nbsp;</td>
		<td><?php echo $mediahuntTask['MediahuntTask']['active']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Admin->link($mediahuntTask['MediahuntEvent']['name'], array('controller' => 'mediahunt_events', 'action' => 'view', $mediahuntTask['MediahuntEvent']['id'])); ?>
		</td>
		<td><?php echo $mediahuntTask['MediahuntTask']['sort_order']; ?>&nbsp;</td>
		<td><?php echo $mediahuntTask['MediahuntTask']['name']; ?>&nbsp;</td>
		<td><?php echo $mediahuntTask['MediahuntTask']['details']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Admin->link(__('View'), array('action' => 'view', $mediahuntTask['MediahuntTask']['id'])); ?>
			<?php echo $this->Admin->link(__('Edit'), array('action' => 'edit', $mediahuntTask['MediahuntTask']['id'])); ?>
			<?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $mediahuntTask['MediahuntTask']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $mediahuntTask['MediahuntTask']['id'])); ?>
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
		<li><?php echo $this->Admin->link(__('New Mediahunt Task'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Admin->link(__('List Mediahunt Events'), array('controller' => 'mediahunt_events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Mediahunt Event'), array('controller' => 'mediahunt_events', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Mediahunt Media Items'), array('controller' => 'mediahunt_media_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Mediahunt Media Item'), array('controller' => 'mediahunt_media_items', 'action' => 'add')); ?> </li>
	</ul>
</div>