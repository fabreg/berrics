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

	font-size:18px;

}
.order-info {

	float:right;
	width:40%;
	text-align:right;
	font-size:10px;
}

.addresses {
	
	float:left;
	width:50%;
	font-size:10px;
}

.items {

	padding-top:10px;
	

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
	font-size:11px;
	border:1px solid #999;
	border-bottom:none;
	border-right:none;
	padding:2px;
	
}

.items table td strong {


}

.addresses .UserAddress {

	font-size:11px;

}

.addresses .UserAddress .heading {

	font-weight:bold;

}

.order-info table {

	font-size:14px;

}
.order-info table td {

	padding:2px;
	font-size:11px;
}

.order-info table td:nth-child(1) {
	
	text-align:right;
	font-weight:bold;

}

</style>
<div class='shipping-record'>
<div class='header'>

<div class='addresses'>
<h1>Berrics Canteen Packing List</h1>
	<?php echo $this->element("canteen_printing/user-address",array("ua"=>$record['UserAddress'],"heading"=>"Ship To:")); ?>
</div>
<div class='order-info'>
<table cellspacing='0' align='right'>
	
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
		<div><strong>WH: </strong><?php echo $child['CanteenInventoryRecord']['Warehouse']['name']; ?> <strong>Item#: </strong><?php echo $child['CanteenInventoryRecord']['foreign_key']; ?></div>
		<div><strong>Item:</strong> <?php echo $child['title']; ?> | <?php echo $child['sub_title']; ?> | By: <?php echo $child['brand_label']; ?></div>
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
		
	</div>
	<div style='float:right;'>
		
	</div>
	<div style='clear:both;'></div>
</div>
</div>