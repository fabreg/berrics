<style>
* {

	padding:0px;
	margin:0px;

}
body {

	font-family:'Times New Roman';
	font-size:12px;
}
.invoice {

	padding:10px;
	display:block; 
	page-break-after:always;
	
}
.invoice .shipping {

	float:left;

}

.invoice .billing {

	float:right;

}

.berrics-info {

	float:left;

}

.order-info {

	float:right;
	width:380px;
}
.order-info td {
	
	padding:1px;
	
}

.shipping {

	float:left;
	width:300px;
}

.billing {

	float:right;
	width:300px;
}

.line-items td {


	border-bottom:1px solid #999;

}

.line-items th {

	border-bottom:1px solid #999;

}

.totals {

	width:200px;
	float:right;

}

.totals td {

	padding:3px;

}
.totals td:nth-child(1) {

	font-weight:600;

}
</style>
<div class='invoice'>
	<div class='header'>
		
		<div class='berrics-info'>
			<h1 style='margin-top:-4px;'>The Berrics Canteen</h1>
			1248 Palmetto St<br />
			Los Angeles CA, xxxxx
		</div>
		<div class='order-info'>
			<table cellspacing='0' cellpadding='5' border='0'>
				<tr>
					<td align='right' width='1%' nowrap ><strong>Order ID:</strong></td>
					<td><?php echo strtoupper($order['CanteenOrder']['id']); ?></td>
				</tr>
				<tr>
				<td align='right' width='1%' nowrap ><strong>Order Status:</strong></td>
					<td><?php echo strtoupper($order['CanteenOrder']['order_status']); ?></td>
				</tr>
				<td align='right' width='1%' nowrap ><strong>Shipping Carrier:</strong></td>
					<td><?php echo strtoupper($order['CanteenOrder']['shipping_carrier']); ?></td>
				</tr>
			</table>
		</div>
		
		<div style='clear:both;'></div>
	</div>
	<hr />
	<div class='customer-info'>
		<div class='shipping'>
			<h4>Ship To:</h4>
			<table cellspacing='0' border='0'>
				<tr>
					<td><?php echo $order['CanteenOrder']['first_name']; ?> <?php echo $order['CanteenOrder']['last_name']; ?> &lt;<?php echo $order['CanteenOrder']['email']; ?>&gt;</td>
				</tr>
				<tr>
					<td><?php echo $order['CanteenOrder']['street_address']; ?> <?php echo $order['CanteenOrder']['apt']; ?>
				</tr>
				<tr>
					<td><?php echo $order['CanteenOrder']['city']; ?>, <?php echo $order['CanteenOrder']['state']; ?> <?php echo $order['CanteenOrder']['postal']; ?> <?php echo $order['CanteenOrder']['country']; ?></td>
				</tr>
				<tr>
					<td><?php echo $order['CanteenOrder']['phone']; ?>
				</tr>
			</table>
		</div>
		<div class='billing'>
			<h4>Bill To:</h4>
			<table cellspacing='0' border='0'>
				<tr>
					<td><?php echo $order['CanteenOrder']['bill_first_name']; ?> <?php echo $order['CanteenOrder']['bill_last_name']; ?></td>
				</tr>
				<tr>
					<td><?php echo $order['CanteenOrder']['bill_address']; ?> 
				</tr>
				<tr>
					<td><?php echo $order['CanteenOrder']['bill_city']; ?>, <?php echo $order['CanteenOrder']['bill_state']; ?> <?php echo $order['CanteenOrder']['bill_postal']; ?> <?php echo $order['CanteenOrder']['bill_country']; ?></td>
				</tr>
			</table>
		</div>
		<div style='clear:both;'></div>
	</div>
	<hr />
	<div class='line-items'>
		<table cellspacing='0' width='100%'>
			<tr>
				<th align='left'>Item</th>
				<th>Qty</th>
				<th>Tax</th>
				<th>Sub-Total</th>
			</tr>
			<?php foreach($order['CanteenOrderItem'] as $i): ?>
			<tr>
				<td>
					<?php echo $i['CanteenProduct']['name']; ?> 
					<?php if(isset($i['CanteenProductOption']['id'])): ?>
					<br /><?php echo $i['CanteenProductOption']['opt_label']; ?>:<?php echo $i['CanteenProductOption']['opt_value']; ?>
					<?php endif; ?>
					<div style='font-size:11px;'>
					<strong>A:</strong><?php echo $i['CanteenProduct']['aisle_num']; ?> <strong>B:</strong><?php echo $i['CanteenProduct']['bin_num']; ?>
					</div>
				</td>
				
				<td align='center'><?php echo $i['quantity']; ?></td>
				<td align='center'>
					<?php echo $i['sales_tax']; ?> (<?php echo $order['CanteenOrder']['currency_id']; ?>)
				</td>
				<td align='center'><?php echo $i['price']; ?> (<?php echo $order['CanteenOrder']['currency_id']; ?>)</td>
			</tr>
			<?php endforeach;?>
		</table>
	</div>
	<div class='totals'>
	<table cellspacing='0' cellpadding='2'>
		<tr>
			<td align='right' width='1%' nowrap>Sub-Total</td>
			<td><?php echo $order['CanteenOrder']['sub_total']; ?> (<?php echo $order['CanteenOrder']['currency_id']; ?>)</td>
		</tr>
		<tr>
			<td align='right' width='1%' nowrap>Tax</td>
			<td><?php echo $order['CanteenOrder']['tax_total']; ?> (<?php echo $order['CanteenOrder']['currency_id']; ?>)</td>
		</tr>
		<tr>
			<td align='right' width='1%' nowrap>Shipping</td>
			<td><?php echo $order['CanteenOrder']['shipping_total']; ?> (<?php echo $order['CanteenOrder']['currency_id']; ?>)</td>
		</tr>
		<tr>
			<td align='right' width='1%' nowrap >Total</td>
			<td><?php echo $order['CanteenOrder']['total']; ?> (<?php echo $order['CanteenOrder']['currency_id']; ?>)</td>
		</tr>
	</table>
	</div>
	<div style='clear:both;'></div>
	<div style='padding:10px; text-align:right;'>
		<img src='http://dev.admin.theberrics.com/canteen_orders/barcode/?num=<?php echo strtoupper($order['CanteenOrder']['id']); ?>'/>
	</div>
</div>