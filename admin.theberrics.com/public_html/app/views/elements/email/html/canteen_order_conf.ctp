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
Your order has been approved and you will momentarily receive an email with your shipment information.<br />
<?php else: ?>
While your order has been authorized it may still need further review. Expect and email or a phone call from us with an updated status of your order in the next 24-48 hours.<br />
<?php 
	endif;
?>
You can always check the status of your order on theberrics.com by using the following link: <br />
<a href='http://theberrics.com/canteen/order/<?php echo $o['CanteenOrder']['id']; ?>'>http://theberrics.com/canteen/order/<?php echo $o['CanteenOrder']['id']; ?></a>
</p>
<p>
The contents of your order including your shipping address is listed below.<br />
Should you have any questions, feel free to contact us.
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
<table width='100%' cellspacing='0' cellpadding='5'>
	<tr>
		<th align='left' bgcolor='#ccc'>Item</th>
		<th bgcolor='#ccc'>Qty</th>
	</tr>
	<?php 
		foreach($o['CanteenOrderItem'] as $item):
			foreach($item['ChildCanteenOrderItem'] as $child):
	?>
		<tr>
			<td><?php echo $child['title']; ?> <?php (!empty($child['sub_title']) ? "-".$child['sub_title']:"")?></td>
			<td><?php echo $child['quantity']; ?></td>
		</tr>
	<?php
			endforeach; 
		endforeach;
	?>
</table>
<h4>Totals</h4>
<table cellspacing='0' cellpadding='5' width='100%'>
	<tr>
		<td>Sub Total</td>
		<td><?php echo $o['CanteenOrder']['sub_total']; ?></td>
	</tr>
		<tr>
		<td>Tax Total</td>
		<td><?php echo $o['CanteenOrder']['tax_total']; ?></td>
	</tr>
	<tr>
		<td>Shipping</td>
		<td><?php echo $o['CanteenOrder']['shipping_total']; ?></td>
	</tr>
	<tr>
		<td>Total</td>
		<td><?php echo $o['CanteenOrder']['grand_total']; ?></td>
	</tr>
</table>