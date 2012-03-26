<div class="systemMessages form">
<?php echo $this->Form->create('SystemMessage');?>
	<fieldset>
		<legend><?php __('Edit System Message'); ?></legend>
	<?php
		echo $this->Form->input('id');
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

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('SystemMessage.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('SystemMessage.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List System Messages', true), array('action' => 'index'));?></li>
	</ul>
</div>