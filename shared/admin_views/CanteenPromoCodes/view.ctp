<div class="canteenPromoCodes view">
<h2><?php echo __('Canteen Promo Code');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenPromoCode['CanteenPromoCode']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenPromoCode['CanteenPromoCode']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenPromoCode['CanteenPromoCode']['modified']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Expire Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenPromoCode['CanteenPromoCode']['expire_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Start Date'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenPromoCode['CanteenPromoCode']['start_date']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('User Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenPromoCode['CanteenPromoCode']['user_id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenPromoCode['CanteenPromoCode']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Rate'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenPromoCode['CanteenPromoCode']['rate']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Promo Type'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenPromoCode['CanteenPromoCode']['promo_type']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php echo __('Promo Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $canteenPromoCode['CanteenPromoCode']['promo_code']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Admin->link(__('Edit Canteen Promo Code'), array('action' => 'edit', $canteenPromoCode['CanteenPromoCode']['id'])); ?> </li>
		<li><?php echo $this->Admin->link(__('Delete Canteen Promo Code'), array('action' => 'delete', $canteenPromoCode['CanteenPromoCode']['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $canteenPromoCode['CanteenPromoCode']['id'])); ?> </li>
		<li><?php echo $this->Admin->link(__('List Canteen Promo Codes'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Canteen Promo Code'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Admin->link(__('List Canteen Orders'), array('controller' => 'canteen_orders', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Admin->link(__('New Canteen Order'), array('controller' => 'canteen_orders', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php echo __('Related Canteen Orders');?></h3>
	<?php if (!empty($canteenPromoCode['CanteenOrder'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Modified'); ?></th>
		<th><?php echo __('Order Status'); ?></th>
		<th><?php echo __('Shipping Status'); ?></th>
		<th><?php echo __('Fulfillment Status'); ?></th>
		<th><?php echo __('Currency Id'); ?></th>
		<th><?php echo __('Grand Total'); ?></th>
		<th><?php echo __('Sub Total'); ?></th>
		<th><?php echo __('Tax Total'); ?></th>
		<th><?php echo __('Discount Total'); ?></th>
		<th><?php echo __('Shipping Total'); ?></th>
		<th><?php echo __('Canteen Promo Code Id'); ?></th>
		<th><?php echo __('Ip Address'); ?></th>
		<th><?php echo __('Geo Ip Country'); ?></th>
		<th><?php echo __('Fraud'); ?></th>
		<th><?php echo __('Shipping Method'); ?></th>
		<th><?php echo __('User Account Canteen Promo Code Id'); ?></th>
		<th><?php echo __('Promotion Canteen Promo Code Id'); ?></th>
		<th><?php echo __('Hash'); ?></th>
		<th class="actions"><?php echo __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($canteenPromoCode['CanteenOrder'] as $canteenOrder):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $canteenOrder['id'];?></td>
			<td><?php echo $canteenOrder['created'];?></td>
			<td><?php echo $canteenOrder['modified'];?></td>
			<td><?php echo $canteenOrder['order_status'];?></td>
			<td><?php echo $canteenOrder['shipping_status'];?></td>
			<td><?php echo $canteenOrder['fulfillment_status'];?></td>
			<td><?php echo $canteenOrder['currency_id'];?></td>
			<td><?php echo $canteenOrder['grand_total'];?></td>
			<td><?php echo $canteenOrder['sub_total'];?></td>
			<td><?php echo $canteenOrder['tax_total'];?></td>
			<td><?php echo $canteenOrder['discount_total'];?></td>
			<td><?php echo $canteenOrder['shipping_total'];?></td>
			<td><?php echo $canteenOrder['canteen_promo_code_id'];?></td>
			<td><?php echo $canteenOrder['ip_address'];?></td>
			<td><?php echo $canteenOrder['geo_ip_country'];?></td>
			<td><?php echo $canteenOrder['fraud'];?></td>
			<td><?php echo $canteenOrder['shipping_method'];?></td>
			<td><?php echo $canteenOrder['user_account_canteen_promo_code_id'];?></td>
			<td><?php echo $canteenOrder['promotion_canteen_promo_code_id'];?></td>
			<td><?php echo $canteenOrder['hash'];?></td>
			<td class="actions">
				<?php echo $this->Admin->link(__('View'), array('controller' => 'canteen_orders', 'action' => 'view', $canteenOrder['id'])); ?>
				<?php echo $this->Admin->link(__('Edit'), array('controller' => 'canteen_orders', 'action' => 'edit', $canteenOrder['id'])); ?>
				<?php echo $this->Admin->link(__('Delete'), array('controller' => 'canteen_orders', 'action' => 'delete', $canteenOrder['id']), null, sprintf(__('Are you sure you want to delete # %s?'), $canteenOrder['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Admin->link(__('New Canteen Order'), array('controller' => 'canteen_orders', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
