<div class="unifiedShops form">
<?php echo $this->Form->create('UnifiedShop');?>
	<fieldset>
 		<legend><?php echo __('Edit Unified Shop'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('street_address');
		echo $this->Form->input('apt_suite');
		echo $this->Form->input('city');
		echo $this->Form->input('state');
		echo $this->Form->input('country');
		echo $this->Form->input('postal_code');
		echo $this->Form->input('phone_number');
		echo $this->Form->input('territory');
		echo $this->Form->input('channel');
		echo $this->Form->input('contact_email');
		echo $this->Form->input('contact_name');
		echo $this->Form->input('user_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit'));?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Admin->link(__('Delete'), array('action' => 'delete', $this->Form->value('UnifiedShop.id')), null, sprintf(__('Are you sure you want to delete # %s?'), $this->Form->value('UnifiedShop.id'))); ?></li>
		<li><?php echo $this->Admin->link(__('List Unified Shops'), array('action' => 'index'));?></li>
		<li><?php echo $this->Admin->link(__('List Users'), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New User'), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>