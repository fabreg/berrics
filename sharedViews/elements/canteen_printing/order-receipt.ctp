<?php 
$this->layout = "canteen_printer";
?>
<style>

.order-receipt {
	
	padding:5px;

}
.addresses {

	font-size:12px;

}

.addresses .heading {

	font-size:14px;
	font-weight:bold;

}
.addresses .UserAddress {

	width:300px;
	float:left;
}
.addresses .UserAddress:nth-child(2) {

	float:right;

}


.items {

	padding-top:10px;
	border-top:2px solid #999;

}

.items table {

	width:99%;
	margin:auto;
	border:1px solid #999;
	border-left:none;
	border-top:none;
	
}

.items table th {

	text-align:left;
	font-size:14px;
	border:1px solid #999;
	border-bottom:none;
	border-right:none;
	background-color:#f0f0f0;
	padding:5px;
}

.items table td {

	text-align:left;
	font-size:12px;
	border:1px solid #999;
	border-bottom:none;
	border-right:none;
	padding:5px;
}


.totals {

	

}

.header {

	border-bottom:2px solid #999;

}

.canteen-info  {

	float:left;
	font-size:12px;
}


.canteen-info h1 {
	
	font-size:22px;

}

.order-info {

	width:200px;
	float:right;
	font-size:12px;
}

.order-info table {
	
	font-size:12px;

}

.order-info table td {

	white-space:nowrap;
	padding:1px;
}

.order-info table td:nth-child(1) {

	font-weight:bold;
	white-space:nowrap;
	text-align:right;


}
.totals {

	
	float:right;
	
	
}

.totals td {

	padding:1px;
	font-size:14px;
	white-space:nowrap;
}

.totals td:nth-child(1) {

	text-align:right;
	font-weight:bold;
	
}

body {

	height:100%;
	background-image:url(/img/berrics-invoice-bg.jpg);
	background-repeat:no-repeat;
	background-position:bottom right;
	
}
</style>
<div class='order-receipt'>
<div class='header'>
	<div class='canteen-info'>
		<h1>The Berrics Canteen</h1>
		<div>
			<div>123 Fake St</div>
			<div>Fake City</div>
			<div>Fake Number</div>
			<div>Fake Email</div>
		</div>
	</div>
	<div class='order-info'>
		<table cellspacing='0'>
			<tr>
				<td>Order ID:</td>
				<td><?php echo $order['CanteenOrder']['id']; ?></td>
			</tr>
			<tr>
				<td>Order Date:</td>
				<td><?php echo date('M d, Y',strtotime($order['CanteenOrder']['created'])); ?></td>
			</tr>
			<tr>
				<td>Order Status:</td>
				<td><?php echo strtoupper($order['CanteenOrder']['order_status']); ?></td>
			</tr>
			<tr>
				<td>Shipping Method:</td>
				<td><?php echo strtoupper($order['CanteenOrder']['shipping_method']); ?></td>
			</tr>
		</table>
	</div>
	<div style='clear:both;'></div>
</div>
<div class='addresses'>
	<?php echo $this->element("canteen_printing/user-address",array("ua"=>$order['ShippingAddress'],"heading"=>"Ship To:")); ?>
		<?php echo $this->element("canteen_printing/user-address",array("ua"=>$order['BillingAddress'],"heading"=>"Bill To:")); ?>
	<div style='clear:both;'></div>
</div>
<div class='items'>
<table cellspacing='0'>
<tr>
	<th width='1%'  style='text-align:center;'>-</th>
	<th>Item(s)</th>
	<th style='text-align:center;'>Price</th>
</tr>
<?php foreach($order['CanteenOrderItem'] as $item): ?>
<tr>
	<td  style='text-align:center;'>
	-
	</td>
	<td>
		<?php foreach($item['ChildCanteenOrderItem'] as $child): ?>
		<div>
			<div><strong>Item:</strong> <?php echo $child['title']; ?> </div>
			<div><?php echo $child['sub_title']; ?></div>
			<div>Qty: <?php echo $child['quantity']; ?></div>
		</div>
		<?php endforeach; ?>
	</td>
	<td  style='text-align:center;'>
		<?php echo $item['sub_total']; ?>
	</td>
</tr>
<?php endforeach; ?>
<?php if(!empty($order['UserAccountCanteenPromoCode']['name'])): ?>
<tr>
	<td colspan='3'>
		<?php echo $order['UserAccountCanteenPromoCode']['name']; ?>
	</td>
</tr>
<?php endif; ?>
</table>
</div>
<div>
	<div class='shipments'>
	
	</div>
	<div class='totals'>
		<table cellspacing='0'>
			<?php if($order['CanteenOrder']['discount_total']!=0): ?>
			<tr>
				<td>Discount Total:</td>
				<td><?php echo number_format($order['CanteenOrder']['discount_total'],2); ?></td>
			</tr>
			<?php endif; ?>
			<tr>
				<td>Sub Total:</td>
				<td><?php echo number_format($order['CanteenOrder']['sub_total'],2); ?></td>
			</tr>
			<tr>
				<td>Tax:</td>
				<td><?php echo number_format($order['CanteenOrder']['tax_total'],2); ?></td>
			</tr>
			<tr>
				<td>Shipping:</td>
				<td><?php echo number_format($order['CanteenOrder']['shipping_total'],2); ?></td>
			</tr>
			<tr>
				<td>Grand Total:</td>
				<td><?php echo number_format($order['CanteenOrder']['grand_total'],2); ?> (<?php echo $order['CanteenOrder']['currency_id']; ?>)</td>
			</tr>
		</table>
	</div>
	<div style='clear:both;'></div>
</div>
</div>