<div class="pollVotingOptions form">
<?php echo $this->Form->create('PollVotingOption'); ?>
	<fieldset>
		<legend><?php echo __('Edit Poll Voting Option'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('poll_id');
		echo $this->Form->input('name');
		echo $this->Form->input('display_weight');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('PollVotingOption.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('PollVotingOption.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Poll Voting Options'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Polls'), array('controller' => 'polls', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Poll'), array('controller' => 'polls', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Poll Voting Records'), array('controller' => 'poll_voting_records', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Poll Voting Record'), array('controller' => 'poll_voting_records', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Poll Voting Results'), array('controller' => 'poll_voting_results', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Poll Voting Result'), array('controller' => 'poll_voting_results', 'action' => 'add')); ?> </li>
	</ul>
</div>
