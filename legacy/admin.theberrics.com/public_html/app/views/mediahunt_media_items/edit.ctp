<div class="mediahuntMediaItems form">
<?php echo $this->Form->create('MediahuntMediaItem');?>
	<fieldset>
		<legend><?php __('Edit Mediahunt Media Item'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('modfied');
		echo $this->Form->input('user_id');
		echo $this->Form->input('title');
		echo $this->Form->input('description');
		echo $this->Form->input('media_type');
		echo $this->Form->input('active');
		echo $this->Form->input('file_name');
		echo $this->Form->input('approved');
		echo $this->Form->input('rank');
		echo $this->Form->input('mediahunt_task_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('MediahuntMediaItem.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('MediahuntMediaItem.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Mediahunt Media Items', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Mediahunt Tasks', true), array('controller' => 'mediahunt_tasks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mediahunt Task', true), array('controller' => 'mediahunt_tasks', 'action' => 'add')); ?> </li>
	</ul>
</div>