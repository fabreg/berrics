<div class="polls view">
<h2><?php  echo __('Poll'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($poll['Poll']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($poll['Poll']['modified']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Start Date'); ?></dt>
		<dd>
			<?php echo h($poll['Poll']['start_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('End Date'); ?></dt>
		<dd>
			<?php echo h($poll['Poll']['end_date']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Name'); ?></dt>
		<dd>
			<?php echo h($poll['Poll']['name']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($poll['Poll']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Active'); ?></dt>
		<dd>
			<?php echo h($poll['Poll']['active']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Website'); ?></dt>
		<dd>
			<?php echo $this->Html->link($poll['Website']['name'], array('controller' => 'websites', 'action' => 'view', $poll['Website']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Poll'), array('action' => 'edit', $poll['Poll']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Poll'), array('action' => 'delete', $poll['Poll']['id']), null, __('Are you sure you want to delete # %s?', $poll['Poll']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Polls'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Poll'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Websites'), array('controller' => 'websites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Website'), array('controller' => 'websites', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Poll Voting Options'), array('controller' => 'poll_voting_options', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Poll Voting Option'), array('controller' => 'poll_voting_options', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Poll Voting Options'); ?></h3>
	<?php if (!empty($poll['PollVotingOption'])): ?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Poll Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Display Weight'); ?></th>
		<th class="actions"><?php echo __('Actions'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($poll['PollVotingOption'] as $pollVotingOption): ?>
		<tr>
			<td><?php echo $pollVotingOption['id']; ?></td>
			<td><?php echo $pollVotingOption['poll_id']; ?></td>
			<td><?php echo $pollVotingOption['name']; ?></td>
			<td><?php echo $pollVotingOption['display_weight']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'poll_voting_options', 'action' => 'view', $pollVotingOption['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'poll_voting_options', 'action' => 'edit', $pollVotingOption['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'poll_voting_options', 'action' => 'delete', $pollVotingOption['id']), null, __('Are you sure you want to delete # %s?', $pollVotingOption['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Poll Voting Option'), array('controller' => 'poll_voting_options', 'action' => 'add')); ?> </li>
		</ul>
	</div>
</div>
