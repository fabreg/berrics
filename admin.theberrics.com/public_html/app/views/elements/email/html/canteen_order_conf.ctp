<?php 

$oo = unserialize($msg['EmailMessage']['serialized_data']);

$co = ClassRegistry::init("CanteenOrder");

$o = $co->returnAdminOrder($oo['CanteenOrder']['id']);


?>
<div>
<p>
<?php echo $o['ShippingAddress']['first_name']; ?>,<br />
Thanks for shopping at The Berrics Canteen.<br />
This email confirms we have received and approved your order.<br />
<?php if($o['CanteenOrder']['order_status'] == "approved"): ?>
You will receive another email once your order has shipped. <br />
<?php else: ?>
While your order has been authorized it may still need further review. Expect and email or a phone call from us with an updated status of your order in the next 24-48 hours.<br />
<?php 
	endif;
?> 
Should you have a question or to check the status of your order, please use the following link:<br /><br />
<a href='http://theberrics.com/canteen/order/<?php echo $o['CanteenOrder']['hash']; ?>'>http://theberrics.com/canteen/order/<?php echo $o['CanteenOrder']['hash']; ?></a>
</p>

<h2>Order #: <?php echo $o['CanteenOrder']['id']; ?></h2>
</div>
<div>
	<div style='float:left; width:300px;'>
		<div><strong>Ship To:</strong></div>
		<div><?php echo $o['ShippingAddress']['first_name']; ?> <?php echo $o['ShippingAddress']['last_name']; ?></div>
		<div><?php echo $o['ShippingAddress']['street']; ?> <?php echo $o['ShippingAddress']['apt']; ?></div>
		<div><?php echo $o['ShippingAddress']['city']; ?> <?php echo $o['ShippingAddress']['state']; ?>, <?php echo $o['ShippingAddress']['postal_code']; ?></div>
		<div><?php echo $o['ShippingAddress']['phone']; ?></div>
		<div>Shipping Method: <?php echo strtoupper($o['CanteenOrder']['shipping_method']); ?></div>
	</div>
	<div></div>
	<div style='clear:both;'></div>
</div>
<h4>Order Items</h4>
<table width='100%' cellspacing='0' cellpadding='5' border='1'>
	<tr>
		<th align='left' bgcolor='#ccc'>Item</th>
		<th bgcolor='#ccc' align='center'>Qty</th>
	</tr>
	<?php 
		foreach($o['CanteenOrderItem'] as $item):
			foreach($item['ChildCanteenOrderItem'] as $child):
	?>
	<tr>
		<td><?php echo $child['title']; ?> <?php echo 'By: '.$child['brand_label']; ?> <?php echo (!empty($child['sub_title'])) ? "<br />".$child['sub_title']:""; ?></td>
		<td align='center'><?php echo $child['quantity']; ?></td>
	</tr>
	<?php
			endforeach; 
		endforeach;
	?>
	<?php if(!empty($o['UserAccountCanteenPromoCode']['name'])): ?>
	<tr>
		<td colspan='2'>
			<?php echo $o['UserAccountCanteenPromoCode']['name']; ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php if(!empty($o['ShippingCanteenPromoCode']['name'])): ?>
	<tr>
		<td colspan='2'>
			<?php echo $o['ShippingCanteenPromoCode']['name']; ?>
		</td>
	</tr>
	<?php endif; ?>
</table>
<table cellspacing='0' cellpadding='5' align='right'>
	<?php if($o['CanteenOrder']['discount_total']!=0): ?>
	<tr>
		<td width='120' nowrap align='right'><strong>Discount Total</strong></td>
		<td style='border-bottom:1px solid #000;'><?php echo $o['CanteenOrder']['discount_total']; ?></td>
	</tr>
	<?php endif; ?>
	<tr>
		<td width='80' nowrap align='right'><strong>Sub Total</strong></td>
		<td style='border-bottom:1px solid #000;'><?php echo $o['CanteenOrder']['sub_total']; ?></td>
	</tr>
	<tr>
		<td width='80' nowrap align='right'><strong>Tax Total</strong></td>
		<td style='border-bottom:1px solid #000;'><?php echo $o['CanteenOrder']['tax_total']; ?></td>
	</tr>
	<tr>
		<td width='80' nowrap align='right'><strong>Shipping</strong></td>
		<td style='border-bottom:1px solid #000;'><?php echo $o['CanteenOrder']['shipping_total']; ?></td>
	</tr>
	<tr>
		<td width='80' nowrap align='right'><strong>Total</strong></td>
		<td style='border-bottom:1px solid #000;' nowrap width='150'><?php echo $o['CanteenOrder']['grand_total']; ?> (<?php echo $o['CanteenOrder']['currency_id']; ?>)</td>
	</tr>
</table>
<div style='padding:20px; clear:both; text-align:center;'>
	<a href='http://dev.theberrics.com/canteen/printable/receipt/<?php echo $o['CanteenOrder']['hash']; ?>'>
		Click here for a printer friendly receipt
	</a>
</div>