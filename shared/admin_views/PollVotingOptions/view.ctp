<div class="pollVotingOptions view">
<h2><?php  echo __('Poll Voting Option'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($pollVotingOption['PollVotingOption']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Poll'); ?></dt>
		<dd>
			<?php echo $this->Html->link($pollVotingOption['Poll']['name'], array('controller' => 'polls', 'action' => 'view', $pollVotingOption['Poll']['id'])); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($pollVotingOption['PollVotingOption']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Display Weight'); ?></dt>
		<dd>
			<?php echo h($pollVotingOption['PollVotingOption']['display_weight']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Poll Voting Option'), array('action' => 'edit', $pollVotingOption['PollVotingOption']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Poll Voting Option'), array('action' => 'delete', $pollVotingOption['PollVotingOption']['id']), null, __('Are you sure you want to delete # %s?', $pollVotingOption['PollVotingOption']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Poll Voting Options'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Poll Voting Option'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Polls'), array('controller' => 'polls', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Poll'), array('controller' => 'polls', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Poll Voting Records'), array('controller' => 'poll_voting_records', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Poll Voting Record'), array('controller' => 'poll_voting_records', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Poll Voting Results'), array('controller' => 'poll_voting_results', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Poll Voting Result'), array('controller' => 'poll_voting_results', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Poll Voting Records'); ?></h3>
	<?php if (!empty($pollVotingOption['PollVotingRecord'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('User Id'); ?></th>
		<th><?php echo __('Session Id'); ?></th>
		<th><?php echo __('Poll Voting Option Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($pollVotingOption['PollVotingRecord'] as $pollVotingRecord): ?>
		<tr>
			<td><?php echo $pollVotingRecord['id']; ?></td>
			<td><?php echo $pollVotingRecord['user_id']; ?></td>
			<td><?php echo $pollVotingRecord['session_id']; ?></td>
			<td><?php echo $pollVotingRecord['poll_voting_option_id']; ?></td>
			<td><?php echo $pollVotingRecord['created']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'poll_voting_records', 'action' => 'view', $pollVotingRecord['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'poll_voting_records', 'action' => 'edit', $pollVotingRecord['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'poll_voting_records', 'action' => 'delete', $pollVotingRecord['id']), null, __('Are you sure you want to delete # %s?', $pollVotingRecord['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Poll Voting Record'), array('controller' => 'poll_voting_records', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php echo __('Related Poll Voting Results'); ?></h3>
	<?php if (!empty($pollVotingOption['PollVotingResult'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Poll Voting Option Id'); ?></th>
		<th><?php echo __('Vote Count'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($pollVotingOption['PollVotingResult'] as $pollVotingResult): ?>
		<tr>
			<td><?php echo $pollVotingResult['id']; ?></td>
			<td><?php echo $pollVotingResult['poll_voting_option_id']; ?></td>
			<td><?php echo $pollVotingResult['vote_count']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'poll_voting_results', 'action' => 'view', $pollVotingResult['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'poll_voting_results', 'action' => 'edit', $pollVotingResult['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'poll_voting_results', 'action' => 'delete', $pollVotingResult['id']), null, __('Are you sure you want to delete # %s?', $pollVotingResult['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Poll Voting Result'), array('controller' => 'poll_voting_results', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
