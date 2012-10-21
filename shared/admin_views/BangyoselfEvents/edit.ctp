<div class="bangyoselfEvents form">
<?php echo $this->Form->create('BangyoselfEvent');?>
	<fieldset>
 		<legend><?php echo __('Edit Bangyoself Event'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $this->Form->value('BangyoselfEvent.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('BangyoselfEvent.id'))); ?></li>
		<li><?php echo $this->Admin->link(__('List Bangyoself Events'), array('action' => 'index'));?></li>
		<li><?php echo $this->Admin->link(__('List Bangyoself Entries'), array('controller' => 'bangyoself_entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Bangyoself Entry'), array('controller' => 'bangyoself_entries', 'action' => 'add')); ?> </li>
	</ul>
</div>