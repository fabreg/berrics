<div class="polls index">
	<h2><?php echo __('Polls'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('modified'); ?></th>
			<th><?php echo $this->Paginator->sort('start_date'); ?></th>
			<th><?php echo $this->Paginator->sort('end_date'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('description'); ?></th>
			<th><?php echo $this->Paginator->sort('active'); ?></th>
			<th><?php echo $this->Paginator->sort('website_id'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($polls as $poll): ?>
	<tr>
		<td><?php echo h($poll['Poll']['id']); ?>&nbsp;</td>
		<td><?php echo h($poll['Poll']['modified']); ?>&nbsp;</td>
		<td><?php echo h($poll['Poll']['start_date']); ?>&nbsp;</td>
		<td><?php echo h($poll['Poll']['end_date']); ?>&nbsp;</td>
		<td><?php echo h($poll['Poll']['name']); ?>&nbsp;</td>
		<td><?php echo h($poll['Poll']['description']); ?>&nbsp;</td>
		<td><?php echo h($poll['Poll']['active']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($poll['Website']['name'], array('controller' => 'websites', 'action' => 'view', $poll['Website']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $poll['Poll']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $poll['Poll']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $poll['Poll']['id']), null, __('Are you sure you want to delete # %s?', $poll['Poll']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>	</p>

	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
	?>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Poll'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Websites'), array('controller' => 'websites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Website'), array('controller' => 'websites', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Poll Voting Options'), array('controller' => 'poll_voting_options', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Poll Voting Option'), array('controller' => 'poll_voting_options', 'action' => 'add')); ?> </li>
	</ul>
</div>
