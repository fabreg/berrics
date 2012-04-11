<?php

$this->layout = "canteen_printer";
$total = 0;
?>
<style>
body {

	font-family:'Courier';

}

.shipping-record {

	padding:5px;

}

.shipping-record h1 {

	font-size:22px;

}
.order-info {

	float:right;

}

.addresses {
	
	float:left;

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
	padding:2px;
}

.items table td {

	text-align:left;
	font-size:12px;
	border:1px solid #999;
	border-bottom:none;
	border-right:none;
	padding:2px;
	
}

.items table td strong {

	width:55px;
	text-align:right;
	display:block;
	float:left;
}

.addresses .UserAddress {

	font-size:13px;

}

.addresses .UserAddress .heading {

	font-weight:bold;

}

.order-info table {

	font-size:14px;

}
.order-info table td {

	padding:2px;
	
}

.order-info table td:nth-child(1) {
	
	text-align:right;
	font-weight:bold;

}

</style>
<div class='shipping-record'>
<div class='header'>

<div class='addresses'>
<h1>The Berrics Canteen - Packing List</h1>
	<?php echo $this->element("canteen_printing/user-address",array("ua"=>$record['UserAddress'],"heading"=>"Ship To:")); ?>
</div>
<div class='order-info'>
<table cellspacing='0'>
	
	<tr>
		<td>Shipment ID:</td>
		<td><?php echo $record['CanteenShippingRecord']['id']; ?></td>
	</tr>
	<tr>
		<td>Shipment Created:</td>
		<td><?php echo date("M d, Y",strtotime($record['CanteenShippingRecord']['created'])); ?></td>
	</tr>
	<tr>
		<td>Order ID:</td>
		<td><?php echo $record['CanteenOrder']['id']; ?></td>
	</tr>
	<tr>
		<td>Warehouse:</td>
		<td><?php echo $record['Warehouse']['name']; ?></td>
	</tr>
</table>
</div>
<div style='clear:both;'></div>
</div>

<div class='items'>
<table cellspacing='0'>

<tr>
	<th width='1%'  style='text-align:center;'>-</th>
	<th>Item</th>
	<th style='text-align:center;'>Qty</th>
	
</tr>
<?php foreach($record['CanteenOrderItem'] as $child): 

	$total += $child['quantity'];
	
?>
<tr>
	<td  style='text-align:center;'>
	-
	</td>
	<td>
		<div><strong>Item:</strong> <?php echo $child['title']; ?> | <?php echo $child['sub_title']; ?></div>
		<div><strong>WH: </strong><?php echo $child['CanteenInventoryRecord']['Warehouse']['name']; ?></div>
		<div><strong>Item#: </strong><?php echo $child['CanteenInventoryRecord']['foreign_key']; ?></div>
		
	</td>

	<td style='text-align:center;'>
		 <?php echo $child['quantity']; ?>
	</td>
</tr>
<?php endforeach; ?>
</table>
</div>
<div style='padding:5px;'>
	<div style='float:right;'>
		<div style='font-weight:bold; padding-bottom:5px;'>Totals Items:<span style='text-decoration:underline;'><?php echo $total; ?> </span></div>
		<img border='0' src='http://dev.admin.theberrics.com/canteen_orders/barcode?num=<?php echo $record['CanteenShippingRecord']['id']; ?>' />
	</div>
	<div style='float:right;'>
		
	</div>
	<div style='clear:both;'></div>
</div>
</div>