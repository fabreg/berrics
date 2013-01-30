<div class="videoTaskServers form">
<?php echo $this->Form->create('VideoTaskServer'); ?>
	<fieldset>
		<legend><?php echo __('Add Video Task Server'); ?></legend>
	<?php
		echo $this->Form->input('server');
		echo $this->Form->input('active');
		echo $this->Form->input('max_tasks');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Video Task Servers'), array('action' => 'index')); ?></li>
	</ul>
</div>
