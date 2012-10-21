<div class="unitedShops form">
<?php echo $this->Form->create('UnitedShop');?>
	<fieldset>
 		<legend><?php echo __('Add United Shop'); ?></legend>
	<?php
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Admin->link(__('List United Shops'), array('action' => 'index'));?></li>
	</ul>
</div>