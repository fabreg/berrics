<div class="mediahuntEvents form">
<?php echo $this->Form->create('MediahuntEvent');?>
	<fieldset>
		<legend><?php echo __('Add Mediahunt Event'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('active');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Admin->link(__('List Mediahunt Events'), array('action' => 'index'));?></li>
		<li><?php echo $this->Admin->link(__('List Mediahunt Tasks'), array('controller' => 'mediahunt_tasks', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Mediahunt Task'), array('controller' => 'mediahunt_tasks', 'action' => 'add')); ?> </li>
	</ul>
</div>