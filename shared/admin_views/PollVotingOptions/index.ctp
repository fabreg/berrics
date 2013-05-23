<div class="pollVotingOptions index">
	<h2><?php echo __('Poll Voting Options'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('poll_id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
			<th><?php echo $this->Paginator->sort('display_weight'); ?></th>
			<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
	foreach ($pollVotingOptions as $pollVotingOption): ?>
	<tr>
		<td><?php echo h($pollVotingOption['PollVotingOption']['id']); ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($pollVotingOption['Poll']['name'], array('controller' => 'polls', 'action' => 'view', $pollVotingOption['Poll']['id'])); ?>
		</td>
		<td><?php echo h($pollVotingOption['PollVotingOption']['name']); ?>&nbsp;</td>
		<td><?php echo h($pollVotingOption['PollVotingOption']['display_weight']); ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View'), array('action' => 'view', $pollVotingOption['PollVotingOption']['id'])); ?>
			<?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $pollVotingOption['PollVotingOption']['id'])); ?>
			<?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $pollVotingOption['PollVotingOption']['id']), null, __('Are you sure you want to delete # %s?', $pollVotingOption['PollVotingOption']['id'])); ?>
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
		<li><?php echo $this->Html->link(__('New Poll Voting Option'), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Polls'), array('controller' => 'polls', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Poll'), array('controller' => 'polls', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Poll Voting Records'), array('controller' => 'poll_voting_records', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Poll Voting Record'), array('controller' => 'poll_voting_records', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Poll Voting Results'), array('controller' => 'poll_voting_results', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Poll Voting Result'), array('controller' => 'poll_voting_results', 'action' => 'add')); ?> </li>
	</ul>
</div>
