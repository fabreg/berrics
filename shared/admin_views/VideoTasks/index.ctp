<div class="page-header">
	<h1>Video Tasks</h1>
</div>
<?php echo $this->Admin->adminPaging(); ?>
<div class="videoTasks index">

	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('created'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('working'); ?></th>
			<th><?php echo $this->Paginator->sort('task_status'); ?></th>
			<th><?php echo $this->Paginator->sort('model'); ?></th>
			<th><?php echo $this->Paginator->sort('foreign_key'); ?></th>
			<th><?php echo $this->Paginator->sort('task'); ?></th>
		
			
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($videoTasks as $videoTask): ?>
	<tr>
		<td><?php echo h($videoTask['VideoTask']['id']); ?>&nbsp;</td>
		<td><?php echo h($videoTask['VideoTask']['created']); ?>&nbsp;</td>
		<td><?php echo h($videoTask['VideoTask']['modified']); ?>&nbsp;</td>
		<td><?php echo h($videoTask['VideoTask']['working']); ?>&nbsp;</td>
		<td><?php echo h($videoTask['VideoTask']['task_status']); ?>&nbsp;</td>
		<td><?php echo h($videoTask['VideoTask']['model']); ?>&nbsp;</td>
		<td><?php echo h($videoTask['VideoTask']['foreign_key']); ?>&nbsp;</td>
		<td><?php echo h($videoTask['VideoTask']['task']); ?>&nbsp;</td>
		
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $videoTask['VideoTask']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $videoTask['VideoTask']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $videoTask['VideoTask']['id']), null, __('Are you sure you want to delete # %s?', $videoTask['VideoTask']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
<?php echo $this->Admin->adminPaging(); ?>
