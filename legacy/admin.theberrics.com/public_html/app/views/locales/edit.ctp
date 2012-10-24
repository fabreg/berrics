<div class="locales form">
<?php echo $this->Form->create('Locale');?>
	<fieldset>
 		<legend><?php __('Edit Locale'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('locale');
		echo $this->Form->input('charset');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('Locale.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('Locale.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Locales', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Offers', true), array('controller' => 'offers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Offer', true), array('controller' => 'offers', 'action' => 'add')); ?> </li>
	</ul>
</div>