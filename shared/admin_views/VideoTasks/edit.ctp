<div class="videoTasks form">
<?php echo $this->Form->create('VideoTask'); ?>
	<fieldset>
		<legend><?php echo __('Edit Video Task'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('task_status');
		echo $this->Form->input('model');
		echo $this->Form->input('foreign_key');
		echo $this->Form->input('task');
		echo $this->Form->input('parameter_data');
		echo $this->Form->input('working');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('VideoTask.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('VideoTask.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Video Tasks'), array('action' => 'index')); ?></li>
	</ul>
</div>
