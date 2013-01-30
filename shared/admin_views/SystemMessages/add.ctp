<div class="systemMessages form">
<?php echo $this->Form->create('SystemMessage');?>
	<fieldset>
		<legend><?php echo __('Add System Message'); ?></legend>
	<?php
		echo $this->Form->input('category');
		echo $this->Form->input('title');
		echo $this->Form->input('message');
		echo $this->Form->input('crontab');
		echo $this->Form->input('alert');
		echo $this->Form->input('from');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Admin->link(__('List System Messages'), array('action' => 'index'));?></li>
	</ul>
</div>