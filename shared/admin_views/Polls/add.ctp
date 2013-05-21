<div class="polls form">
<?php echo $this->Form->create('Poll'); ?>
	<fieldset>
		<legend><?php echo __('Add Poll'); ?></legend>
	<?php
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

		<li><?php echo $this->Html->link(__('List Polls'), array('action' => 'index')); ?></li>
		<li><?php echo $this->Html->link(__('List Websites'), array('controller' => 'websites', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Website'), array('controller' => 'websites', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Poll Voting Options'), array('controller' => 'poll_voting_options', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Poll Voting Option'), array('controller' => 'poll_voting_options', 'action' => 'add')); ?> </li>
	</ul>
</div>
