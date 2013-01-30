<?php 

$l = Lang::instance();

$cf = $l->returnSection("CommonFields",$user_locale);

$this->set(array(
	"title_for_layout"=>"Order Confirmation"
));

$countries = Arr::countries();

$shipping = Set::extract("/UserAddress[address_type=shipping]",$order);

$billing = Set::extract("/UserAddress[address_type=billing]",$order);

$shipping = $order['ShippingAddress'];
$billing = $order['BillingAddress'];

?>
<div id='canteen-invoice'>
	<div class='invoice'>
		<div class='large-heading'>
			<h1>ORDER CONFIRMATION</h1>
		</div>
				<div class='message'>
					<div class='inner'>
						<p> <?php echo $shipping['first_name']; ?>,<br /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Thank you for your order. This receipt is to confirm that The Canteen has received your order.
						You will also receive an email confirmation from do.not.reply@theberrics.com. Please check your bulk/spam folders and white list theberrics.com for future coresponsdence regarding your order.
						You may also use the following link to view an up-to-the-minute status of your order and ask any questions that you may have.
						</p>
						<div style='text-align:center; padding:6px; font-weight:bold;'>
							<a href='/canteen/order/<?php echo $order['CanteenOrder']['hash']; ?>' target='_blank'>http://theberrics.com/canteen/order/<?php echo $order['CanteenOrder']['hash']; ?></a>
						</div>
						<div style='text-align:center; padding:6px; font-weight:bold;'>
							<a href='/canteen/printable/receipt/<?php echo $order['CanteenOrder']['hash']; ?>' target='_blank'>Click Here To Print Your Receipt</a>
						</div>
					</div>
				</div>

				<div class='row-fluid customer'>
					<div class="span6">
						<table class='table table-bordered table-striped table-rounded' cellspacing='0'>
							<thead>
								<tr>
									<th>SHIP TO:</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<?php echo $shipping['first_name']; ?> <?php echo $shipping['last_name']; ?> <span style='font-size:11px'>[<?php echo $shipping['email']; ?>]</span>
									</td>
								</tr>
								<tr>
									<td>
										<?php echo $shipping['street']; ?> <?php echo $shipping['apt']; ?>
									</td>
								</tr>
								<tr>
									<td>
										<?php echo $shipping['city']; ?>, <?php echo $shipping['state']; ?> <?php echo $shipping['postal_code']; ?> <?php echo strtoupper($countries[$shipping['country_code']]); ?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="span6">
						<table cellspacing="0" class="table table-striped table-bordered table-rounded">
							<thead>
								<tr>
									<th>BILL TO:</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
											<?php echo $billing['first_name']; ?> <?php echo $billing['last_name']; ?>
									</td>
								</tr>
								<tr>
									<td>
											<?php echo $billing['street']; ?>
									</td>
								</tr>
								<tr>
									<td>
											<?php echo $billing['postal_code']; ?> <?php echo strtoupper($countries[$billing['country_code']]);  ?>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					
					
				</div>
				<div class='invoice-items'>
					<table cellspacing='0' class='table table-bordered table-striped table-rounded'>
						<tr>
							<th width='90%' align='left' style='text-align:left; padding-left:10px;'>ITEMS</th>
							<th>QUANTITY</th>
						</tr>
						<?php foreach($order['CanteenOrderItem'] as $parent): 
								foreach($parent['ChildCanteenOrderItem'] as $item):
						?>
							
						<tr>
							<td>
							<?php echo strtoupper($item['title']); ?> <span>By: <?php echo strtoupper($item['brand_label']); ?></span>
							<?php if(!empty($item['sub_title'])) echo " <br /> ".strtoupper($item['sub_title']); ?>
							
							</td>
							<td align='center' style='text-align:center;'>
								<?php echo $item['quantity']; ?>
							</td>
						</tr>
						<?php 
								endforeach;
							endforeach; 
						?>
					</table>
				</div>
				<div class='cart-totals row-fluid'>
					<div class="span4 offset8">
						<table cellspacing="0" class="table table-bordered table-striped table-rounded">
							<?php if($order['CanteenOrder']['discount_total'] != 0): ?>
							<tr>
								<td>Discount</td>
								<td><?php echo number_format($order['CanteenOrder']['discount_total'],2); ?></td>
							</tr>
							<?php endif; ?>
							<tr>
								<td>Sub Total</td>
								<td><?php echo $this->Berrics->currency($order['CanteenOrder']['sub_total'],$order['CanteenOrder']['currency_id']); ?></td>
							</tr>
							<tr>
								<td>Tax</td>
								<td><?php echo $this->Berrics->currency($order['CanteenOrder']['tax_total'],$order['CanteenOrder']['currency_id']); ?></td>
							</tr>
							<tr>
								<td>Shipping</td>
								<td><?php echo $this->Berrics->currency($order['CanteenOrder']['shipping_total'],$order['CanteenOrder']['currency_id']); ?></td>
							</tr>
							<tr>
								<td>Grand Total</td>
								<td><?php echo $this->Berrics->currency($order['CanteenOrder']['grand_total'],$order['CanteenOrder']['currency_id']); ?> (<?php echo $order['CanteenOrder']['currency_id']; ?>)</td>
							</tr>
						</table>
					</div>
				</div>
	</div>
	
</div>