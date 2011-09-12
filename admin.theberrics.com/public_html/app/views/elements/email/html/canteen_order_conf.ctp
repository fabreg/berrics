<?php 

$oo = unserialize($msg['EmailMessage']['serialized_data']);

$co = ClassRegistry::init("CanteenOrder");

$o = $co->returnAdminOrder($oo['CanteenOrder']['id']);

?>
<div>
<p>
<?php echo $o['CanteenOrder']['first_name']; ?>,<br />
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
<dl>
		<dt>Name</dt>
		<dd><?php echo $o['CanteenOrder']['first_name']; ?> <?php echo $o['CanteenOrder']['last_name']?></dd>
	</dl>
</div>
<h4>Order Items</h4>
<table width='100%' cellspacing='0' cellpadding='5'>
	<tr>
		<th align='left' bgcolor='#ccc'>Item</th>
		<th bgcolor='#ccc'>Qty</th>
	</tr>
	<?php 
		foreach($o['CanteenOrderItem'] as $item):
	?>
	<tr>
	<td>
		<?php echo $item['CanteenProduct']['name']; ?>
	</td>
	<td align='center'><?php echo $item['quantity']; ?></td>
	</tr>
	<?php 
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
		<td>Shipping</td>
		<td>-</td>
	</tr>
	<tr>
		<td>Total</td>
		<td><?php echo $o['CanteenOrder']['total']; ?></td>
	</tr>
</table>