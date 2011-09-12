<div class="unitedShops form">
<?php echo $this->Form->create('UnitedShop');?>
	<fieldset>
 		<legend><?php __('Add United Shop'); ?></legend>
	<?php
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List United Shops', true), array('action' => 'index'));?></li>
	</ul>
</div>