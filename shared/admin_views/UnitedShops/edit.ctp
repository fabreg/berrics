<div class="unitedShops form">
<?php echo $this->Form->create('UnitedShop');?>
	<fieldset>
 		<legend><?php echo __('Edit United Shop'); ?></legend>
	<?php
		echo $this->Form->input('id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $this->Form->value('UnitedShop.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('UnitedShop.id'))); ?></li>
		<li><?php echo $this->Admin->link(__('List United Shops'), array('action' => 'index'));?></li>
	</ul>
</div>