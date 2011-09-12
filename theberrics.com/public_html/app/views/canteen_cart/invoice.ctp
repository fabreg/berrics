<?php 

$l = Lang::instance();

$cf = $l->returnSection("CommonFields",$user_locale);

$this->set(array(
	"title_for_layout"=>"Order Invoice"
));

?>
<style>
#canteen-order-confirmation {

	background-image:url(/img/layout/canteen/order-conf-bg.jpg);
	height:668px;
	color:#222;
	position:relative;
	font-family:"Courier New", Courier, monospace;
	font-size:13px;
	
}

#canteen-order-confirmation a {

	color:inherit;

}

#canteen-order-confirmation .message {
	
	font-size:14px;
	width:95%;
	margin:auto;
	font-family:'Times New Roman';
	text-align:justify;
	text-indent:15px;
	font-weight:600;
}



#canteen-order-confirmation .top-spacer {

	height:75px;

}

#canteen-order-confirmation .ship-to {
	
	float:left;
	width:52%;
	margin-left:4%;
	font-weight:bold;
}

#canteen-order-confirmation .bill-to {
	
	float:right;
	width:39%;
	margin-right:3%;
	font-weight:bold;
}

#canteen-order-confirmation .heading {

	font-weight:bold;
	font-size:16px;
	font-family:'Times New Roman';
	
}

#canteen-order-confirmation .customer {

	padding-top:10px;

}

#canteen-order-confirmation .items {
	
	width:95%;
	margin:auto;
	margin-top:10px;
}

#canteen-order-confirmation .items table {
	
	width:100%;
	border:none;
}
#canteen-order-confirmation .items table th {

	font-family:'Times New Roman';
	font-size:16px;
	border-bottom:1px solid #333;

}
#canteen-order-confirmation .items table td {

	padding:2px;
	border-bottom:1px solid #333;
	padding-top:6px;
	padding-bottom:6px;
	font-weight:600;
}

#canteen-order-confirmation .totals {

	
	width:95%;
	margin:auto;
	margin-top:10px;
}

#canteen-order-confirmation .totals table {

	width:200px;
	float:right;
	font-weight:600;

}

#canteen-order-confirmation .totals table td {
	
	padding:3px;
	

}

#canteen-order-confirmation .totals table td:nth-child(1) {
	
	font-family:'Times New Roman';
	font-weight:bold;

}

#canteen-order-confirmation .totals table td:nth-child(2) {

border-bottom:1px solid #333;

}

</style>
<div style='text-align:center'>
<a href='/canteen/cart/print_invoice/<?php echo $order['CanteenOrder']['id']; ?>' target='_blank'>Printable Version</a>
</div>
<div id='canteen-order-confirmation'>
	<div class='top-spacer'></div>
	<div class='message'>
		<?php echo $order['CanteenOrder']['bill_first_name']; ?>, thank you for your order. This receipt is to confirm that The Canteen has received your order.
		You will also receive an email confirmation from do.not.reply@theberrics.com. Please check your bulk/spam folders and white list theberrics.com for future coresponsdence regarding your order.
		You may also use the following link to view an up-to-the-minute status of your order and ask any questions that you may have.
		<div style='text-align:center; padding:6px; font-weight:bold;'>
			<a href='http://dev.theberrics.com/canteen/order/<?php echo $order['CanteenOrder']['id']; ?>' target='_blank'>http://theberrics.com/canteen/order/<?php echo $order['CanteenOrder']['id']; ?></a>
		</div>
	</div>
	<div class='customer'>
		<div class='ship-to'>
			<div class='heading'>Ship To:</div>
			<?php echo $order['CanteenOrder']['first_name']; ?> <?php echo $order['CanteenOrder']['last_name']; ?> &lt;<?php echo $order['CanteenOrder']['email']; ?>&gt;
			<br />
			<?php echo $order['CanteenOrder']['street_address']; ?> <?php echo $order['CanteenOrder']['apt']; ?>
			<br />
			<?php echo $order['CanteenOrder']['city']; ?>, <?php echo $order['CanteenOrder']['state']; ?> <?php echo $order['CanteenOrder']['postal']; ?>
			<br />
			<?php echo $order['CanteenOrder']['country']; ?>
		</div>
		<div class='bill-to'>
			<div class='heading'>Bill To:</div>
			<?php echo $order['CanteenOrder']['bill_first_name']; ?> <?php echo $order['CanteenOrder']['bill_last_name']; ?>
			<br />
			<?php echo $order['CanteenOrder']['bill_address']; ?>
			<br />
			<?php echo $order['CanteenOrder']['bill_city']; ?>, <?php echo $order['CanteenOrder']['bill_state']; ?> <?php echo $order['CanteenOrder']['bill_postal']; ?>
			<br />
			<?php echo $order['CanteenOrder']['bill_country']; ?>
		</div>
		<div style='clear:both;'></div>
	</div>
	<div class='items'>
		<table cellspacing='0'>
			<tr>
				<th width='90%' align='left'>Item</th>
				<th>Qty</th>
			</tr>
			<?php foreach($order['CanteenOrderItem'] as $item): ?>
			<tr>
				<td>
				<?php echo $item['CanteenProduct']['name']; ?>
				<?php 
					if(isset($item['CanteenProductOption']['id'])):
				?>
				<br />
				<?php echo $item['CanteenProductOption']['opt_label']; ?>:<?php echo $item['CanteenProductOption']['opt_value']; ?>
				<?php 
					endif;
				?>
				</td>
				<td align='center'>
					<?php echo $item['quantity']; ?>
				</td>
			</tr>
			<?php endforeach; ?>
		</table>
		
	</div>
	<div class='totals'>
		<table cellspacing='0'>
			<tr>
				<td width='1%' align='right' nowrap>Sub-Total</td>
				<td><?php echo $order['CanteenOrder']['sub_total']; ?> (<?php echo $order['CanteenOrder']['currency_id']; ?>)</td>
			</tr>
			<tr>
				<td width='1%' align='right' nowrap>Tax</td>
				<td><?php echo $order['CanteenOrder']['tax_total']; ?> (<?php echo $order['CanteenOrder']['currency_id']; ?>)</td>
			</tr>
			<tr>
				<td width='1%' align='right' nowrap>Shipping</td>
				<td><?php echo $order['CanteenOrder']['shipping_total']; ?> (<?php echo $order['CanteenOrder']['currency_id']; ?>)</td>
			</tr>
			<tr>
				<td width='1%' align='right' nowrap>Total</td>
				<td><?php echo $order['CanteenOrder']['total']; ?> (<?php echo $order['CanteenOrder']['currency_id']; ?>)</td>
			</tr>
		</table>
	</div>
</div>

<pre>
	<?php //print_r($order); ?>
</pre>