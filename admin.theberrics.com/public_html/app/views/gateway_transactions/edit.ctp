<div class="gatewayTransactions form">
<?php echo $this->Form->create('GatewayTransaction');?>
	<fieldset>
 		<legend><?php __('Edit Gateway Transaction'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('gateway_account_id');
		echo $this->Form->input('method');
		echo $this->Form->input('approved');
		echo $this->Form->input('cc_hash');
		echo $this->Form->input('exp');
		echo $this->Form->input('user_id');
		echo $this->Form->input('first_name');
		echo $this->Form->input('last_name');
		echo $this->Form->input('address');
		echo $this->Form->input('city');
		echo $this->Form->input('country');
		echo $this->Form->input('state');
		echo $this->Form->input('postal');
		echo $this->Form->input('phone');
		echo $this->Form->input('amount');
		echo $this->Form->input('currency_id');
		echo $this->Form->input('error');
		echo $this->Form->input('error_code');
		echo $this->Form->input('gateway_response_code');
		echo $this->Form->input('gateway_customer_id');
		echo $this->Form->input('email');
		echo $this->Form->input('gateway_response');
		echo $this->Form->input('gateway');
		echo $this->Form->input('gateway_customer_payment_id');
		echo $this->Form->input('model');
		echo $this->Form->input('foreign_key');
		echo $this->Form->input('ref1');
		echo $this->Form->input('ref2');
		echo $this->Form->input('ref3');
		echo $this->Form->input('ref4');
		echo $this->Form->input('ref5');
		echo $this->Form->input('acc_op1');
		echo $this->Form->input('acc_op2');
		echo $this->Form->input('acc_op3');
		echo $this->Form->input('acc_op4');
		echo $this->Form->input('acc_op5');
		echo $this->Form->input('sec_hash');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $this->Form->value('GatewayTransaction.id')), null, sprintf(__('Are you sure you want to delete # %s?', true), $this->Form->value('GatewayTransaction.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Gateway Transactions', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Gateway Accounts', true), array('controller' => 'gateway_accounts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gateway Account', true), array('controller' => 'gateway_accounts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Billing Profiles', true), array('controller' => 'user_billing_profiles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Billing Profile', true), array('controller' => 'user_billing_profiles', 'action' => 'add')); ?> </li>
	</ul>
</div>