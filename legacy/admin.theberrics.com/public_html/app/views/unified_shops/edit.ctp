<div class="unifiedShops form">
<?php echo $this->Form->create('UnifiedShop');?>
	<fieldset>
 		<legend><?php __('Edit Unified Shop'); ?></legend>
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
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('UnifiedShop.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('UnifiedShop.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Unified Shops', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
	</ul>
</div>