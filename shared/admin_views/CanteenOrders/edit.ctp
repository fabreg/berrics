<?php 

	


?>
<script>
$(document).ready(function() { 

	$('.tab-fields').prepend("<div id='tab-nav'><ul></ul><div style='clear:both;'></div></div>");
	
	$('.tab-fields fieldset').each(function() { 
		var l = $(this).find("legend");
		$('#tab-nav ul').append("<li>"+$(l).text()+"</li>");
	});

	$('#tab-nav li').css({
		"float":"left",
		"margin-right":"5px",
		"list-style":"none",
		"border":"1px solid #000",
		"padding":"5px",
		"cursor":"pointer"
	}).click(function() { 

		var ind = $(this).index();

		selectSet(ind);
		
	});

	selectSet(0);

	detectHash();
	
});

function detectHash() {

	var h = document.location.hash;

	if(h.length>1) {

		h = h.replace(/#/,'');

		h = h.toLowerCase();
		
		$('#tab-nav li').each(function() { 

			var t = $(this).text().toLowerCase();

			if(t==h) {

				selectSet($(this).index());

			}
			
		});
		
	}
	
}

function hideAllSets() {

	$('.tab-fields fieldset').hide();

	$('#tab-nav li').css({
		"background-color":""
	});
	
}

function selectSet(ind) {

	hideAllSets();

	$("#tab-nav li:eq("+ind+")").css({
		"background-color":"#e9e9e9"
	});

	$(".tab-fields fieldset:eq("+ind+")").show();
	
}

function handleNote() {


	document.location.href = document.location.href;
	
}

</script>
<style>
.big-table td {

	font-size:18px;

}
.big-table td:nth-child(0) {

	font-weight:bold;

}

.address-div {

	float:left;
	width:350px;
	

}
.address-div td:nth-child(1) {

		text-align:right;
		width:35%;
		font-weight:bold;
}

.shipping-div {

	width:375px;
	float:left;

}

.shipping-div td:nth-child(1) {

		text-align:right;
		width:35%;
		font-weight:bold;
}

#tab-nav {

	padding-top:10px;

}
#tab-nav li {

-moz-border-radius-topleft: 10px;
-moz-border-radius-topright: 10px;
-moz-border-radius-bottomright: 0px;
-moz-border-radius-bottomleft: 0px;
-webkit-border-radius: 10px 10px 0px 0px;
border-radius: 10px 10px 0px 0px;

}
</style>
<div class="page-header">
	<h1>Edit Order <small><?php echo $this->request->data['CanteenOrder']['id']; ?></small></h1>
</div>
<div class='form index'>
	<div class="row-fluid">
		<div class="span4">
			<h3>General Info</h3>
			<div >
				<table cellspacing='0'>
					<tr>
						<td width='30%' align='right'>Order Status</td>
						<td><?php echo strtoupper($this->request->data['CanteenOrder']['order_status']); ?></td>
					</tr>
					
					<tr>
						<td width='30%' align='right'>Shipping Method</td>
						<td><?php echo strtoupper($this->request->data['CanteenOrder']['shipping_method']); ?></td>
					</tr>
					<tr>
						<td width='30%' align='right'>Currency</td>
						<td><?php 
								echo $this->request->data['Currency']['name'];  

								if($this->request->data['Currency']['id'] != "USD") {
									
									echo " ({$this->request->data['Currency']['rate']} VS. USD)";
									
								}
								
						?></td>
					</tr>
					<tr>
						<td width='30%' align='right'>Tax Rate</td>
						<td><?php echo $this->request->data['CanteenOrder']['tax_rate']; ?></td>
					</tr>
					<tr>
						<td width='30%' align='right'>Discount Total</td>
						<td><?php echo $this->Number->currency($this->request->data['CanteenOrder']['discount_total'],$this->request->data['Currency']['id']); ?></td>
					</tr>
					<tr>
						<td width='30%' align='right'>Sub Total</td>
						<td><?php echo $this->Number->currency($this->request->data['CanteenOrder']['sub_total'],$this->request->data['Currency']['id']); ?></td>
					</tr>
					<tr>
						<td width='30%' align='right'>Tax Total</td>
						<td><?php echo $this->Number->currency($this->request->data['CanteenOrder']['tax_total'],$this->request->data['Currency']['id']); ?></td>
					</tr>
					<tr>
						<td width='30%' align='right'>Shipping Total</td>
						<td><?php echo $this->Number->currency($this->request->data['CanteenOrder']['shipping_total'],$this->request->data['Currency']['id']); ?></td>
					</tr>
					<tr>
						<td width='30%' align='right'>Grand Total</td>
						<td><?php echo $this->Number->currency($this->request->data['CanteenOrder']['grand_total'],$this->request->data['Currency']['id']); ?></td>
					</tr>
				</table>
			</div>
		</div>
		<div class="span8">
			<h3>Transactions</h3>
			<div>
				<ul class='actions'>
					<li>
						<a href='http://theberrics.com/canteen/order/<?php echo $this->request->data['CanteenOrder']['hash']; ?>' target='_blank'>
							Order Status Link
						</a>
					</li>
					<li>
						<a href='/canteen_orders/cancel_order/<?php echo $this->request->data['CanteenOrder']['id']; ?>' onclick='return confirm("Are you sure you want to cancel this order?"); '>
							Cancel Order
						</a>
					</li>
					<li>
						<a href='/canteen_shipping_records/add/canteen_order_id:<?php echo $this->request->data['CanteenOrder']['id']; ?>/callback:<?php echo base64_encode($this->request->here); ?>'>Create and Attach New Shipment</a>
					</li>
				</ul>
				<div style='clear:both;'></div>
				<h3>Transactions</h3>
				<table cellspacing='0'>
					<tr>
						<th>Created/Modified</th>
						<th>Gateway/Account</th>
						<th>Approved</th>
						<th>Currency</th>
						<th>Type</th>
						<th>Amount</th>
						<th>Action</th>
					</tr>
					<?php 
						$ttotal = 0;
						foreach($this->request->data['GatewayTransaction'] as $t): 
						
						
						
						if($t['approved'] == 1) {
							
							switch(strtoupper($t['method'])) {
								
								case "CHARGE":
								case "CAPTURE":
									$ttotal += $t['amount'];
								break;
								case "REFUND":
									$ttotal -= $t['amount'];
								break;
								
							}
							
						}
						
					?>
					<tr>
						<td align='center'>
						<?php echo $this->Time->niceShort($t['created']); ?>/<?php echo $this->Time->niceShort($t['modified']); ?>
						</td>
						<td align='center'>
							<?php echo $t['GatewayAccount']['provider']; ?>/<?php echo $t['GatewayAccount']['name']; ?>
						</td>
						<td align='center'>
							<?php
							
							switch($t['approved']) {
								
								case 1:
									echo "<span style='color:green;'>Yes</span>";
									break;
								default:
									echo "<span style='color:red;'>No</span>";
									break;
							}
							
							?>
						</td>
						<td align='center'>
							<?php echo $t['currency_id']; ?>
						</td>
						<td align='center'>
							<?php echo $t['method']; ?>
						</td>
						<td align='center'>
							<?php echo number_format($t['amount'],2); ?>
						</td>
						<td class='actions'>
							<a title='<?php echo $t['gateway_response']; ?>'>MSG</a>
							<?php 
								if($t['approved']) {
									
									switch(strtoupper($t['method'])) {
										
										case "CHARGE":
										case "CAPTURE":
											echo "<a href='/canteen_orders/refund_transaction/{$t['id']}'>Refund</a>";
											echo "<a>Charge</a>";
										break;
										case "AUTH":
											if($t['amount']>0) {
												
												echo "<a href='/canteen_orders/capture_order/{$t['id']}'>CAPTURE</a>";
												
											}
											
									}
									
								}
							?>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
				<div style='padding:5px;'><strong>TOTAL CASH FLOW:</strong> <?php echo number_format($ttotal,2); ?></div>
			</div>
		</div>
	</div>
	<div class="tabbable">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#1" data-toggle="tab">Cart Items</a></li>
			<li><a href="#2" data-toggle="tab">Shipments</a></li>
			<li><a href="#3" data-toggle="tab">Addresses</a></li>
			<li><a href="#5" data-toggle="tab">Order Notes</a></li>
			<li><a href="#6" data-toggle="tab">Email Messages</a></li>

		</ul>
		<div class="tab-content">
			<div class="tab-pane active" id="1">
				<h2>Cart Items</h2>
				<div>
					<ul class='actions'>
						<li>
							<a href='/canteen_orders/attach_product/<?php echo $this->request->data['CanteenOrder']['id']; ?>/callback:<?php echo base64_encode($this->request->here); ?>'>Attach Product</a>
						</li>
					
					</ul>
				</div>
				<div  style='clear:both;'></div>
				<div>
					<table cellspacing='0'>
						<tr>
							<th width='1%'>-</th>
							<th>Item</th>
							<th>InventoryRecord</th>
							<th>ShippingRecord</th>
							<th>Qty</th>
							
							<th>Total</th>
							
						</tr>
						<?php foreach($this->request->data['CanteenOrderItem'] as $item): ?>
							
							<?php foreach($item['ChildCanteenOrderItem'] as $child): ?>
							<tr style='background-color:#f0f0f0;'>
								<td>
									<a href='/canteen_orders/edit_line_item/<?php echo $item['id']; ?>'>Edit Line</a>
								</td>
								<td>
									<div style='float:left; margin:4px;'>
										<?php echo $this->Media->productThumb($child['CanteenProduct']['ParentCanteenProduct']['CanteenProductImage'][0],array("w"=>40)); ?>
									</div>
									<?php echo $child['title']; ?> <?php if(!empty($child['sub_title'])) echo " <br /> ".$child['sub_title']; ?>
									<br />
									Price: <?php echo number_format($child['sub_total'],2); ?>
									<br />
									<a href='/canteen_orders/remove_item/<?php echo $child['id']; ?>' onclick='return confirm("Are you sure you want to remove this item?"); '>Remove Item</a>
								</td>
								<td>
								<?php if(isset($child['CanteenInventoryRecord']['id'])): ?>
									<strong>WH: </strong><?php echo $child['CanteenInventoryRecord']['Warehouse']['name']; ?><br />
									<strong>ITEM: </strong><?php echo $child['CanteenInventoryRecord']['name']; ?> (#<?php echo $child['CanteenInventoryRecord']['foreign_key']; ?>)<br />
									<strong>QTY: </strong><?php echo $child['CanteenInventoryRecord']['quantity']; ?><br />
									<strong>QTY IN ALLOCATION: </strong><?php echo $child['CanteenInventoryRecord']['allocated']; ?><br />
									<strong>INV PROCESSED:</strong> <?php 
									
										switch($child['inventory_processed']) {
											
											case 1:
												echo "YES";
											break;
											default:
												echo "NO";
											break;
											
										}
									
									?>
								<?php endif; ?>
								</td>
								<td>
									<?php 
										if(!empty($child['canteen_shipping_record_id'])):	
									?>
									<strong>CANTEEN ID: </strong><?php echo $child['CanteenShippingRecord']['id']; ?><br />
									<strong>WH: </strong><?php echo $child['CanteenShippingRecord']['Warehouse']['name']; ?><br />
									<strong>STATUS: </strong><?php echo strtoupper($child['CanteenShippingRecord']['shipping_status']); ?><br />
									<?php 
										endif;
									?>
								</td>
								<td align='center' width='1%' nowrap><?php echo $child['quantity']; ?></td>
								
								<td align='center'>-</td>
							</tr>
							<?php endforeach;?>
							<tr style='background-color:#ccc;'>
								<td>
									-
								</td>
								<td><?php echo $item['title']; if(!empty($item['sub_title'])) echo $item['sub_title']; ?> &nbsp;</td>
								<td align='center'>-</td>
								<td align='center'>-</td>
								<td align='right' nowrap><strong>Line Totals:</strong></td>
							
								<td align='center'><?php echo number_format($item['tax_total']+$item['sub_total'],2); ?></td>
								
							</tr>
						<?php endforeach; ?>
					</table>
				</div>
			</div>
			<div class="tab-pane" id="2">
				<h2>Shipments</h2>
				<div>
					<?php if(count($this->request->data['CanteenShippingRecord'])>0): ?>
						<?php foreach($this->request->data['CanteenShippingRecord'] as $s): ?>
						<div class='shipping-div'>
							<table cellspacing='0'>
								<tr>
									<td>Canteen Shipping ID</td>
									<td><?php echo $s['id']; ?></td>
								</tr>
								<tr>
									<td>Status</td>
									<td><?php echo strtoupper($s['shipping_status']); ?></td>
								</tr>
								<tr>
									<td>Warehouse</td>
									<td><?php echo $s['Warehouse']['name']; ?></td>
								</tr>
								<tr>
									<td>Created/Updated</td>
									<td>
										<?php echo $this->Time->niceShort($s['created']); ?>/<?php echo $this->Time->niceShort($s['modified']); ?>
									</td>
								</tr>
								<tr>
									<td>Method</td>
									<td>
										<?php echo strtoupper($s['shipping_method']); ?>
									</td>
								</tr>
								<tr>
									<td>Carrier</td>
									<td><?php echo $s['carrier_name']; ?></td>
								</tr>
								<tr>
									<td>Tracking</td>
									<td><?php echo $s['tracking_number']; ?></td>
								</tr>
							</table>
						</div>
						<?php endforeach; ?>
					<?php endif;?>
					
				</div>
			</div>
			<div class="tab-pane" id="3">
				<h2>Addresses</h2>
				<div>
					<?php echo $this->element("canteen_orders/address",array("address"=>$this->request->data['ShippingAddress'])) ;?>
					<?php echo $this->element("canteen_orders/address",array("address"=>$this->request->data['BillingAddress'])) ;?>
					<div style='clear:both;'></div>
				</div>
			</div>
			<div class="tab-pane" id="5">
				<h2>Order Notes</h2>
				<?php 
				if(count($this->request->data['CanteenOrderNote'])>0):
				?>
				<table cellspacing='0'>
					<tr>
						<th>ID</th>
						<th>Type</th>
						<th>STATUS</th>
						<th>Created</th>
						<th>From</th>
						<th>Message</th>
						<th>-</th>
					</tr>
					<?php foreach($this->request->data['CanteenOrderNote'] as $note): ?>
					<tr>
						<td width='1%'><?php echo $note['id']; ?></td>
						<td width='1%'>
						<?php 
							
							echo strtoupper($note['note_type']); 	
						
						?>
						</td>
						<td width='1%' align='center'>
						<?php 
							
							echo strtoupper($note['note_status']); 	
						
						?>
						</td>
						<td width='1%' nowrap  align='center'><?php echo $this->Time->niceShort($note['created']); ?></td>
						<td width='15%'  align='center'>
							<?php if(isset($note['User']['id'])): ?>
							<a href='/users/edit/<?php echo $note['User']['id']; ?>' target='_blank'><?php echo $note['User']['first_name']; ?> <?php echo $note['User']['last_name']; ?></a>
							<?php else: ?>
							CUSTOMER
							<?php endif; ?>
						</td>
						<td width='80%'>
						<?php echo nl2br($note['message']); ?>
						</td>
						<td class='actions'>
							<a href='javascript:CanteenOrderNote.reply(<?php echo $note['id']; ?>,"handleNote");'>Reply</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
				<?php else: ?>
				<div>NO NOTES</div>
				<?php endif; ?>
			</div>
			<div class="tab-pane" id="6">
				<h2>Email Messages</h2>
				<table cellspacing='0'>
				<tr>
					<th>ID</th>
					<th>Created</th>
					<th>Sent</th>
					<th>Subject</th>
					<th>To</th>
					<th>-</th>
				</tr>
				<?php foreach($this->request->data['EmailMessage'] as $e): ?>
				<tr>
					<td><?php echo $e['id']; ?></td>
					<td><?php echo $this->Time->niceShort($e['created']); ?></td>
					<td>
					<?php if(!$e['processed']): ?>
					Not Sent
					<?php else: ?>
					<?php echo $this->Time->niceShort($e['sent']); ?>
					<?php endif; ?>
					</td>
					<td><?php echo $e['subject']; ?></td>
					<td><?php echo $e['to']; ?></td>
					<th-></th->
				</tr>
				<?php endforeach; ?>
			</table>
			</div>
		</div>
	</div>

</div>
<div style="height:100px;"></div>
<?php 
pr($this->request->data);
?>