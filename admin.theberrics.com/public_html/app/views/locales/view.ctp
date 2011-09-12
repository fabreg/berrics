<div class="locales view">
<h2><?php  __('Locale');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $locale['Locale']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $locale['Locale']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $locale['Locale']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $locale['Locale']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Locale'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $locale['Locale']['locale']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Charset'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $locale['Locale']['charset']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Locale', true), array('action' => 'edit', $locale['Locale']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Locale', true), array('action' => 'delete', $locale['Locale']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $locale['Locale']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Locales', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Locale', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Offers', true), array('controller' => 'offers', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Offer', true), array('controller' => 'offers', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Offers');?></h3>
	<?php if (!empty($locale['Offer'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th><?php __('Domain Name'); ?></th>
		<th><?php __('Locale Id'); ?></th>
		<th><?php __('Name'); ?></th>
		<th><?php __('Active'); ?></th>
		<th><?php __('User Id'); ?></th>
		<th><?php __('Cost Per Order'); ?></th>
		<th><?php __('Cost Per Fulfillment'); ?></th>
		<th><?php __('Checkout Theme'); ?></th>
		<th><?php __('Currency Id'); ?></th>
		<th><?php __('Rebill Days'); ?></th>
		<th><?php __('Rebill Offer'); ?></th>
		<th><?php __('Order Flow Template'); ?></th>
		<th><?php __('Shipping Rate Zone Id'); ?></th>
		<th><?php __('Tax Zone Id'); ?></th>
		<th><?php __('Terminal Id'); ?></th>
		<th><?php __('Allow Expidited Shipping'); ?></th>
		<th><?php __('Recurring'); ?></th>
		<th><?php __('Recurr Cycle Days'); ?></th>
		<th><?php __('Recurr Initial Cycle Days'); ?></th>
		<th><?php __('Email Sender Id'); ?></th>
		<th><?php __('Recurr Initial Price'); ?></th>
		<th><?php __('Customer Service Script'); ?></th>
		<th><?php __('Save Sale Type'); ?></th>
		<th><?php __('Save Sale Value'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($locale['Offer'] as $offer):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $offer['id'];?></td>
			<td><?php echo $offer['created'];?></td>
			<td><?php echo $offer['modified'];?></td>
			<td><?php echo $offer['domain_name'];?></td>
			<td><?php echo $offer['locale_id'];?></td>
			<td><?php echo $offer['name'];?></td>
			<td><?php echo $offer['active'];?></td>
			<td><?php echo $offer['user_id'];?></td>
			<td><?php echo $offer['cost_per_order'];?></td>
			<td><?php echo $offer['cost_per_fulfillment'];?></td>
			<td><?php echo $offer['checkout_theme'];?></td>
			<td><?php echo $offer['currency_id'];?></td>
			<td><?php echo $offer['rebill_days'];?></td>
			<td><?php echo $offer['rebill_offer'];?></td>
			<td><?php echo $offer['order_flow_template'];?></td>
			<td><?php echo $offer['shipping_rate_zone_id'];?></td>
			<td><?php echo $offer['tax_zone_id'];?></td>
			<td><?php echo $offer['terminal_id'];?></td>
			<td><?php echo $offer['allow_expidited_shipping'];?></td>
			<td><?php echo $offer['recurring'];?></td>
			<td><?php echo $offer['recurr_cycle_days'];?></td>
			<td><?php echo $offer['recurr_initial_cycle_days'];?></td>
			<td><?php echo $offer['email_sender_id'];?></td>
			<td><?php echo $offer['recurr_initial_price'];?></td>
			<td><?php echo $offer['customer_service_script'];?></td>
			<td><?php echo $offer['save_sale_type'];?></td>
			<td><?php echo $offer['save_sale_value'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'offers', 'action' => 'view', $offer['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'offers', 'action' => 'edit', $offer['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'offers', 'action' => 'delete', $offer['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $offer['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Offer', true), array('controller' => 'offers', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
