<div class="polls form">
<?php echo $this->Form->create('Poll'); ?>
	<fieldset>
		<legend><?php echo __('Edit Poll'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('start_date');
		echo $this->Form->input('end_date');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
		echo $this->Form->input('active');
		echo $this->Form->input('website_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('Poll.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('Poll.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Polls'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Websites'), array('controller' => 'websites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Website'), array('controller' => 'websites', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Poll Voting Options'), array('controller' => 'poll_voting_options', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Poll Voting Option'), array('controller' => 'poll_voting_options', 'action' => 'add')); ?> </li>
	</ul>
</div>
