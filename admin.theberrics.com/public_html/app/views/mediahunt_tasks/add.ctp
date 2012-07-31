<div class="mediahuntTasks form">
<?php echo $this->Form->create('MediahuntTask');?>
	<fieldset>
		<legend><?php __('Add Mediahunt Task'); ?></legend>
	<?php
		echo $this->Form->input('active');
		echo $this->Form->input('mediahunt_event_id');
		echo $this->Form->input('sort_order');
		echo $this->Form->input('name');
		echo $this->Form->input('details');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Mediahunt Tasks', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Mediahunt Events', true), array('controller' => 'mediahunt_events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mediahunt Event', true), array('controller' => 'mediahunt_events', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Mediahunt Media Items', true), array('controller' => 'mediahunt_media_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mediahunt Media Item', true), array('controller' => 'mediahunt_media_items', 'action' => 'add')); ?> </li>
	</ul>
</div>