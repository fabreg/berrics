<?php 

$l = Lang::instance();

$cf = $l->returnSection("CommonFields",$user_locale);

$this->set(array(
	"title_for_layout"=>"Order Confirmation"
));

$countries = Arr::countries();

?>
<div id='canteen-invoice'>
	<div class='invoice'>
		<div class='container'>
			<div class='container-top'>
				<div class='header'>
					<h1>ORDER CONFIRMATION</h1>
				</div>
				<div class='message'>
					<div class='inner'>
						<?php echo $order['CanteenOrder']['bill_first_name']; ?>,<br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thank you for your order. This receipt is to confirm that The Canteen has received your order.
						You will also receive an email confirmation from do.not.reply@theberrics.com. Please check your bulk/spam folders and white list theberrics.com for future coresponsdence regarding your order.
						You may also use the following link to view an up-to-the-minute status of your order and ask any questions that you may have.
						<div style='text-align:center; padding:6px; font-weight:bold;'>
							<a href='http://dev.theberrics.com/canteen/order/<?php echo $order['CanteenOrder']['id']; ?>' target='_blank'>http://theberrics.com/canteen/order/<?php echo $order['CanteenOrder']['id']; ?></a>
						</div>
					</div>
				</div>
				<div class='customer'>
					<div class='ship-to'>
						<div class='heading'>SHIP TO:</div>
						<div class='envelope'>
						<?php echo $order['CanteenOrder']['first_name']; ?> <?php echo $order['CanteenOrder']['last_name']; ?> <br />[<?php echo $order['CanteenOrder']['email']; ?>]
						<br />
						<?php echo $order['CanteenOrder']['street_address']; ?> <?php echo $order['CanteenOrder']['apt']; ?>
						<br />
						<?php echo $order['CanteenOrder']['city']; ?>, <?php echo $order['CanteenOrder']['state']; ?> <?php echo $order['CanteenOrder']['postal']; ?>
						<br />
						<?php echo strtoupper($countries[$order['CanteenOrder']['country']]); ?>
						</div>
					</div>
					<div class='bill-to'>
						<div class='heading'>BILL TO:</div>
						<div class='envelope'>
						<?php echo $order['CanteenOrder']['bill_first_name']; ?> <?php echo $order['CanteenOrder']['bill_last_name']; ?>
						<br />
						<?php echo $order['CanteenOrder']['bill_address']; ?>
						<br />
						<?php echo $order['CanteenOrder']['bill_city']; ?>, <?php echo $order['CanteenOrder']['bill_state']; ?> <?php echo $order['CanteenOrder']['bill_postal']; ?>
						<br />
						<?php echo strtoupper($countries[$order['CanteenOrder']['bill_country']]);  ?>
						<br />&nbsp;
						</div>
					</div>
					<div style='clear:both;'></div>
				</div>
				<div class='cart-items'>
								<table cellspacing='0'>
									<tr>
										<th width='90%' align='left'>ITEMS</th>
										<th>QUANTITY</th>
									</tr>
									<?php foreach($order['CanteenOrderItem'] as $item): ?>
									<tr>
										<td>
										<?php echo strtoupper($item['CanteenProduct']['name']); ?><?php if(!empty($item['CanteenProduct']['sub_title'])) echo " - ".strtoupper($item['CanteenProduct']['sub_title']); ?>
										<br />
										<?php 
											if(isset($item['CanteenProductOption']['id'])):
										?>
										
										<?php echo strtoupper($item['CanteenProductOption']['opt_label']); ?>:<?php echo strtoupper($item['CanteenProductOption']['opt_value']); ?>
										<?php 
											endif;
										?>&nbsp;
										</td>
										<td align='center'>
											<?php echo $item['quantity']; ?>
										</td>
									</tr>
									<?php endforeach; ?>
								</table>
				</div>
				<div class='cart-totals'>
					<dl class='totals-list'>
						<dt>Sub-Total..</dt>
						<dd><?php echo $this->Number->currency($order['CanteenOrder']['total'],$order['CanteenOrder']['currency_id']); ?></dd>
						<dt>Shipping...</dt>
						<dd><?php echo $this->Number->currency($order['CanteenOrder']['shipping'],$order['CanteenOrder']['currency_id']); ?></dd>
						<dt class='grand-total-label'>Total......</dt>
						<dd class='grand-total'><?php echo $this->Number->currency($order['CanteenOrder']['total'],$order['CanteenOrder']['currency_id']); ?></dd>
					</dl>
					<div style='clear:both;'></div>
				</div>
			</div>
		</div>
		<div class='bottom'></div>
	</div>
	<div class='right-col'></div>
	<div style='clear:both;'></div>
</div>
<pre>
	<?php //print_r($order); ?>
</pre>