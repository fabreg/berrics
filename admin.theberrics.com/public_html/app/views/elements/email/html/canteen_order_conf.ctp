<?php 

$oo = unserialize($msg['EmailMessage']['serialized_data']);

$co = ClassRegistry::init("CanteenOrder");

$o = $co->returnAdminOrder($oo['CanteenOrder']['id']);

$shipTo = Set::extract("/UserAddress[address_type=shipping]",$o);

?>
<div>
<p>
<?php echo $shipTo[0]['UserAddress']['first_name']; ?>,<br />
This email is to confirm that The Canteen has received your order.<br />
<?php if($o['CanteenOrder']['order_status'] == "approved"): ?>
Your order has been approved and you will receive an additional email once your order has shipped.<br />
<?php else: ?>
While your order has been authorized it may still need further review. Expect and email or a phone call from us with an updated status of your order in the next 24-48 hours.<br />
<?php 
	endif;
?>
Should you have a question or if you would like to check the status of your order, please use the following link: <br />
<a href='http://theberrics.com/canteen/order/<?php echo $o['CanteenOrder']['hash']; ?>'>http://theberrics.com/canteen/order/<?php echo $o['CanteenOrder']['hash']; ?></a>
</p>
<p>
The contents of your order including your shipping address is listed below.
</p>
<h2>Order #: <?php echo $o['CanteenOrder']['id']; ?></h2>
</div>
<div>
	<div style='float:left; width:300px;'>
		<div><strong>Ship To:</strong></div>
		<div><?php echo $shipTo[0]['UserAddress']['first_name']; ?> <?php echo $shipTo[0]['UserAddress']['last_name']; ?></div>
		<div><?php echo $shipTo[0]['UserAddress']['street']; ?> <?php echo $shipTo[0]['UserAddress']['apt']; ?></div>
		<div><?php echo $shipTo[0]['UserAddress']['city']; ?> <?php echo $shipTo[0]['UserAddress']['state']; ?>, <?php echo $shipTo[0]['UserAddress']['postal_code']; ?></div>
		<div><?php echo $shipTo[0]['UserAddress']['phone']; ?></div>
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
</table>
<h4>Totals</h4>
<table cellspacing='0' cellpadding='5' align='left'>
	<tr>
		<td width='80' nowrap align='right'>Sub Total</td>
		<td style='border-bottom:1px solid #000;'><?php echo $o['CanteenOrder']['sub_total']; ?></td>
	</tr>
	<tr>
		<td width='80' nowrap align='right'>Tax Total</td>
		<td style='border-bottom:1px solid #000;'><?php echo $o['CanteenOrder']['tax_total']; ?></td>
	</tr>
	<tr>
		<td width='80' nowrap align='right'>Shipping</td>
		<td style='border-bottom:1px solid #000;'><?php echo $o['CanteenOrder']['shipping_total']; ?></td>
	</tr>
	<tr>
		<td width='80' nowrap align='right'>Total</td>
		<td style='border-bottom:1px solid #000;' nowrap width='150'><?php echo $o['CanteenOrder']['grand_total']; ?> (<?php echo $o['CanteenOrder']['currency_id']; ?>)</td>
	</tr>
</table>