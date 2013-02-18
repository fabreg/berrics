<div class="websites form">
<?php echo $this->Form->create('Website'); ?>
	<fieldset>
		<legend><?php echo __('Add Website'); ?></legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Websites'), array('action' => 'index')); ?></li>
	</ul>
</div>
