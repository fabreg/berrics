<div class="bangyoselfEvents form">
<?php echo $this->Form->create('BangyoselfEvent');?>
	<fieldset>
 		<legend><?php __('Edit Bangyoself Event'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('BangyoselfEvent.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('BangyoselfEvent.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Bangyoself Events', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Bangyoself Entries', true), array('controller' => 'bangyoself_entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bangyoself Entry', true), array('controller' => 'bangyoself_entries', 'action' => 'add')); ?> </li>
	</ul>
</div>