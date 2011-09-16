<?php 

$l = Lang::instance();

$cf = $l->returnSection("CommonFields",$user_locale);

$this->set(array(
	"title_for_layout"=>"Order Invoice"
));

?>
<div style='text-align:center'>
<a href='/canteen/cart/print_invoice/<?php echo $order['CanteenOrder']['id']; ?>' target='_blank'>Printable Version</a>
</div>

<div id='canteen-invoice'>
	
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
	<div style=''></div>
	<div style='clear:both;'></div>
</div>



<pre>
	<?php //print_r($order); ?>
</pre>