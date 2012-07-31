<div class="mediahuntTasks form">
<?php echo $this->Form->create('MediahuntTask');?>
	<fieldset>
		<legend><?php __('Edit Mediahunt Task'); ?></legend>
	<?php
		echo $this->Form->input('id');
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

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('MediahuntTask.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('MediahuntTask.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Mediahunt Tasks', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Mediahunt Events', true), array('controller' => 'mediahunt_events', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mediahunt Event', true), array('controller' => 'mediahunt_events', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Mediahunt Media Items', true), array('controller' => 'mediahunt_media_items', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Mediahunt Media Item', true), array('controller' => 'mediahunt_media_items', 'action' => 'add')); ?> </li>
	</ul>
</div>