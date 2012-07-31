<div class="mediahuntMediaItems index">
	<h2><?php __('Mediahunt Media Items');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modfied');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('title');?></th>
			<th><?php echo $this->Paginator->sort('description');?></th>
			<th><?php echo $this->Paginator->sort('media_type');?></th>
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th><?php echo $this->Paginator->sort('file_name');?></th>
			<th><?php echo $this->Paginator->sort('approved');?></th>
			<th><?php echo $this->Paginator->sort('rank');?></th>
			<th><?php echo $this->Paginator->sort('mediahunt_task_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($mediahuntMediaItems as $mediahuntMediaItem):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $mediahuntMediaItem['MediahuntMediaItem']['id']; ?>&nbsp;</td>
		<td><?php echo $mediahuntMediaItem['MediahuntMediaItem']['created']; ?>&nbsp;</td>
		<td><?php echo $mediahuntMediaItem['MediahuntMediaItem']['modfied']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($mediahuntMediaItem['User']['title'], array('controller' => 'users', 'action' => 'view', $mediahuntMediaItem['User']['id'])); ?>
		</td>
		<td><?php echo $mediahuntMediaItem['MediahuntMediaItem']['title']; ?>&nbsp;</td>
		<td><?php echo $mediahuntMediaItem['MediahuntMediaItem']['description']; ?>&nbsp;</td>
		<td><?php echo $mediahuntMediaItem['MediahuntMediaItem']['media_type']; ?>&nbsp;</td>
		<td><?php echo $mediahuntMediaItem['MediahuntMediaItem']['active']; ?>&nbsp;</td>
		<td><?php echo $mediahuntMediaItem['MediahuntMediaItem']['file_name']; ?>&nbsp;</td>
		<td><?php echo $mediahuntMediaItem['MediahuntMediaItem']['approved']; ?>&nbsp;</td>
		<td><?php echo $mediahuntMediaItem['MediahuntMediaItem']['rank']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($mediahuntMediaItem['MediahuntTask']['name'], array('controller' => 'mediahunt_tasks', 'action' => 'view', $mediahuntMediaItem['MediahuntTask']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $mediahuntMediaItem['MediahuntMediaItem']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $mediahuntMediaItem['MediahuntMediaItem']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $mediahuntMediaItem['MediahuntMediaItem']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $mediahuntMediaItem['MediahuntMediaItem']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Mediahunt Media Item', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Mediahunt Tasks', true), array('controller' => 'mediahunt_tasks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mediahunt Task', true), array('controller' => 'mediahunt_tasks', 'action' => 'add')); ?> </li>
	</ul>
</div>