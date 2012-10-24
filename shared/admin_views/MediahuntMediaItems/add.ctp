<div class="mediahuntMediaItems form">
<?php echo $this->Form->create('MediahuntMediaItem');?>
	<fieldset>
		<legend><?php echo __('Add Mediahunt Media Item'); ?></legend>
	<?php
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
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Admin->link(__('List Mediahunt Media Items'), array('action' => 'index'));?></li>
		<li><?php echo $this->Admin->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Mediahunt Tasks'), array('controller' => 'mediahunt_tasks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Mediahunt Task'), array('controller' => 'mediahunt_tasks', 'action' => 'add')); ?> </li>
	</ul>
</div>