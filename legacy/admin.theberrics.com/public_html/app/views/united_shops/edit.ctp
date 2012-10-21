<div class="unitedShops form">
<?php echo $this->Form->create('UnitedShop');?>
	<fieldset>
 		<legend><?php __('Edit United Shop'); ?></legend>
	<?php
		echo $this->Form->input('id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('UnitedShop.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('UnitedShop.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List United Shops', true), array('action' => 'index'));?></li>
	</ul>
</div>