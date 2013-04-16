<div class="dailyopsConfigs form">
<?php echo $this->Form->create('DailyopsConfig'); ?>
	<fieldset>
		<legend><?php echo __('Add Dailyops Config'); ?></legend>
	<?php
		echo $this->Form->input('dailyops_date');
		echo $this->Form->input('post_frequency');
		echo $this->Form->input('disable_themes');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Dailyops Configs'), array('action' => 'index')); ?></li>
	</ul>
</div>
