<div class="mediahuntEvents form">
<?php echo $this->Form->create('MediahuntEvent');?>
	<fieldset>
		<legend><?php __('Edit Mediahunt Event'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('active');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('MediahuntEvent.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('MediahuntEvent.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Mediahunt Events', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Mediahunt Tasks', true), array('controller' => 'mediahunt_tasks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mediahunt Task', true), array('controller' => 'mediahunt_tasks', 'action' => 'add')); ?> </li>
	</ul>
</div>