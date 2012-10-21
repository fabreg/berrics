<div class="bangyoselfEvents form">
<?php echo $this->Form->create('BangyoselfEvent');?>
	<fieldset>
 		<legend><?php __('Add Bangyoself Event'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('description');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Bangyoself Events', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Bangyoself Entries', true), array('controller' => 'bangyoself_entries', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Bangyoself Entry', true), array('controller' => 'bangyoself_entries', 'action' => 'add')); ?> </li>
	</ul>
</div>