<div class="systemMessages form">
<?php echo $this->Form->create('SystemMessage');?>
	<fieldset>
		<legend><?php __('Add System Message'); ?></legend>
	<?php
		echo $this->Form->input('category');
		echo $this->Form->input('title');
		echo $this->Form->input('message');
		echo $this->Form->input('crontab');
		echo $this->Form->input('alert');
		echo $this->Form->input('from');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List System Messages', true), array('action' => 'index'));?></li>
	</ul>
</div>