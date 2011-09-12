<div class="gatewayTransactions index">
	<h2><?php __('Gateway Transactions');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('gateway_account_id');?></th>
			<th><?php echo $this->Paginator->sort('method');?></th>
			<th><?php echo $this->Paginator->sort('approved');?></th>
			<th><?php echo $this->Paginator->sort('cc_hash');?></th>
			<th><?php echo $this->Paginator->sort('exp');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>
			<th><?php echo $this->Paginator->sort('modified');?></th>
			<th><?php echo $this->Paginator->sort('user_id');?></th>
			<th><?php echo $this->Paginator->sort('first_name');?></th>
			<th><?php echo $this->Paginator->sort('last_name');?></th>
			<th><?php echo $this->Paginator->sort('address');?></th>
			<th><?php echo $this->Paginator->sort('city');?></th>
			<th><?php echo $this->Paginator->sort('country');?></th>
			<th><?php echo $this->Paginator->sort('state');?></th>
			<th><?php echo $this->Paginator->sort('postal');?></th>
			<th><?php echo $this->Paginator->sort('phone');?></th>
			<th><?php echo $this->Paginator->sort('amount');?></th>
			<th><?php echo $this->Paginator->sort('currency_id');?></th>
			<th><?php echo $this->Paginator->sort('error');?></th>
			<th><?php echo $this->Paginator->sort('error_code');?></th>
			<th><?php echo $this->Paginator->sort('gateway_response_code');?></th>
			<th><?php echo $this->Paginator->sort('gateway_customer_id');?></th>
			<th><?php echo $this->Paginator->sort('email');?></th>
			<th><?php echo $this->Paginator->sort('gateway_response');?></th>
			<th><?php echo $this->Paginator->sort('gateway');?></th>
			<th><?php echo $this->Paginator->sort('gateway_customer_payment_id');?></th>
			<th><?php echo $this->Paginator->sort('model');?></th>
			<th><?php echo $this->Paginator->sort('foreign_key');?></th>
			<th><?php echo $this->Paginator->sort('ref1');?></th>
			<th><?php echo $this->Paginator->sort('ref2');?></th>
			<th><?php echo $this->Paginator->sort('ref3');?></th>
			<th><?php echo $this->Paginator->sort('ref4');?></th>
			<th><?php echo $this->Paginator->sort('ref5');?></th>
			<th><?php echo $this->Paginator->sort('acc_op1');?></th>
			<th><?php echo $this->Paginator->sort('acc_op2');?></th>
			<th><?php echo $this->Paginator->sort('acc_op3');?></th>
			<th><?php echo $this->Paginator->sort('acc_op4');?></th>
			<th><?php echo $this->Paginator->sort('acc_op5');?></th>
			<th><?php echo $this->Paginator->sort('sec_hash');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($gatewayTransactions as $gatewayTransaction):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($gatewayTransaction['GatewayAccount']['name'], array('controller' => 'gateway_accounts', 'action' => 'view', $gatewayTransaction['GatewayAccount']['id'])); ?>
		</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['method']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['approved']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['cc_hash']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['exp']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['created']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['modified']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['user_id']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['first_name']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['last_name']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['address']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['city']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['country']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['state']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['postal']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['phone']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['amount']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['currency_id']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['error']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['error_code']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['gateway_response_code']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['gateway_customer_id']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['email']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['gateway_response']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['gateway']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['gateway_customer_payment_id']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['model']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['foreign_key']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['ref1']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['ref2']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['ref3']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['ref4']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['ref5']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['acc_op1']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['acc_op2']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['acc_op3']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['acc_op4']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['acc_op5']; ?>&nbsp;</td>
		<td><?php echo $gatewayTransaction['GatewayTransaction']['sec_hash']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $gatewayTransaction['GatewayTransaction']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $gatewayTransaction['GatewayTransaction']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $gatewayTransaction['GatewayTransaction']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $gatewayTransaction['GatewayTransaction']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Gateway Transaction', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Gateway Accounts', true), array('controller' => 'gateway_accounts', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Gateway Account', true), array('controller' => 'gateway_accounts', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List User Billing Profiles', true), array('controller' => 'user_billing_profiles', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User Billing Profile', true), array('controller' => 'user_billing_profiles', 'action' => 'add')); ?> </li>
	</ul>
</div>