<div class="userAddresses form">
<?php echo $this->Form->create('UserAddress');?>
	<fieldset>
		<legend><?php __('Add User Address'); ?></legend>
	<?php
		echo $this->Form->input('address_type');
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('street');
		echo $this->Form->input('apt');
		echo $this->Form->input('city');
		echo $this->Form->input('postal_code');
		echo $this->Form->input('province');
		echo $this->Form->input('country_code');
		echo $this->Form->input('phone');
		echo $this->Form->input('email');
		echo $this->Form->input('model');
		echo $this->Form->input('foreign_key');
		echo $this->Form->input('user_id');
		echo $this->Form->input('state');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List User Addresses', true), array('action' => 'index'));?></li>
	</ul>
</div>