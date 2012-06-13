<?php 

$this->Html->script(array("/theme/canteen/js/order-status"),array("inline"=>false));


?>
<div id='order-status'>
	<div>
		<div class='order'>
			<div class='heading'>
				CANTEEN ORDER STATUS
			</div>
			<div class='order-bit'>
				<div class='label'>ORDER #</div>
				<div class='value'>
					<?php echo $order['CanteenOrder']['id']; ?>
				</div>
			</div>
			<div class='order-bit'>
				<div class='label'>ORDER STATUS</div>
				<div class='value'>
					<?php 
						switch(strtolower($order['CanteenOrder']['order_status'])) {
							
							case "approved":
								$status_style='color:green; font-weight:bold;';
								break;
							default:
								$status_style = "";
								break;
							
						}
					?>
					<span style='<?php echo $status_style; ?>'><?php echo strtoupper($order['CanteenOrder']['order_status']); ?></span>
				</div>
			</div>
			<div class='order-bit'>
				<div class='label'>ORDER DATE</div>
				<div class='value'>
					<?php echo strtoupper($this->Time->niceShort($order['CanteenOrder']['created'])); ?>
				</div>
			</div>
			<div class='order-bit'>
				<div class='label'>LAST UPDATED</div>
				<div class='value'>
					<?php echo strtoupper($this->Time->niceShort($order['CanteenOrder']['created'])); ?>
				</div>
			</div>
			<div style='clear:both;'></div>
		</div>
		<div class='shipping-records'>
			<div class='heading'>
				SHIPPING STATUS
			</div>
			<?php 
				if(count($order['CanteenShippingRecord'])>0):
					foreach($order['CanteenShippingRecord'] as $k=>$v):
			?>
				<fieldset>
					<legend>
						Shipment <?php echo ($k+1); ?> of <?php echo count($order['CanteenShippingRecord']); ?> 
					</legend>
					<div class='order-bit'>
						<div class='label'>STATUS</div>
						<div class='value'>
							<?php echo strtoupper($v['shipping_status']); ?>
						</div>
					</div>
					<div class='order-bit'>
						<div class='label'>LAST UPDATED</div>
						<div class='value'>
							<?php echo strtoupper($this->Time->niceShort($v['modified'])); ?>
						</div>
					</div>
					<div class='order-bit'>
						<div class='label'>CARRIER</div>
						<div class='value'>
							<?php
							
								if(!empty($v['carrier_name'])) {
									
									echo strtoupper($v['carrier_name']);
									
								} else {
									
									echo "N/A";
									
								}
							
							?>
						</div>
					</div>
					<div class='order-bit'>
						<div class='label'>TRACKING</div>
						<div class='value'>
							<?php
							
								if(!empty($v['shipment_number'])) {
									
									switch(strtoupper($v['carrier_name'])) {
							
											case "USPS":

												if(!empty($v['tracking_number'])) {
					
													echo "<a href='http://trkcnfrm1.smi.usps.com/PTSInternetWeb/InterLabelInquiry.do?origTrackNum={$v['tracking_number']}'>{$v['tracking_number']}</a>";
													
												} else {
													
													echo "<a href='http://trkcnfrm1.smi.usps.com/PTSInternetWeb/InterLabelInquiry.do?origTrackNum={$v['shipment_number']}'>{$v['shipment_number']}</a>";
													
												}
												
											break;
							
									}
									//echo strtoupper($v['tracking_number']);
									
								} else {
									
									echo "N/A";
									
								}
							
							?>
						</div>
					</div>
					<div style='clear:both;'></div>
					<!-- Items -->
					<div class='items'>
						<div class='items-heading'>Contents</div>
						<table cellspacing='0' class='canteen-table-items'>
							<tr>
								<th>-</th>
								<th>Item</th>
								<th>Quantity</th>
							</tr>
							<?php foreach($v['CanteenOrderItem'] as $i): ?>
							<tr>
								<td width='2%'>-</td>
								<td><?php echo $i['title']; ?>  BY: <?php echo $i['brand_label']; ?><br /><?php echo $i['sub_title']; ?></td>
								<td width='10%' align='center' valign='middle'><?php echo $i['quantity']; ?></td>
							</tr>
							<?php endforeach; ?>
						</table>
					</div>	
				</fieldset>
			<?php 
					endforeach;
				else:	
			?>
				<div>
					
				</div>
			<?php 
				endif;
			?>
		</div>
		<div style='clear:both;'></div>
		<div class='heading'>
		ORDER NOTES
		</div>
		<div class='notes-form-div'>
			<div class='order-notes-help'>
			<p>Do you have a question about your order? Use the form to the right to get in touch with us and we will get back to you promptly.</p>
			</div>
			<div class='order-notes-form'>
				<?php 
					echo $this->Form->create("CanteenOrderNote",array("url"=>"/canteen/order_note/".base64_encode($this->here)));
					echo $this->Form->input("action",array("value"=>"customer_note","type"=>"hidden"));
					echo $this->Form->input("canteen_order_id",array("type"=>"hidden","value"=>$order['CanteenOrder']['id']));
					echo $this->Form->input("message",array("label"=>"Your Message"));
					echo $this->Form->submit("Add Note");
					echo $this->Form->end();
				?>
			</div>
			<div style='clear:both;'></div>
		</div>
		<div class='order-notes-container'>
			<?php if(count($order['CanteenOrderNote'])>0): ?>
				<?php foreach($order['CanteenOrderNote'] as $n): if($n['hidden'] == 1) continue; ?>
				<div class='order-note'>
					<table cellspacing='0' class='canteen-table-items'>
						<tr>
							<th></th>
							<th>From</th>
							<th>Message</th>
						</tr>
						<tr>
							<td width='2%'></td>
							<td width='25%' align='center' valign='middle'>
								<?php if(isset($n['User']['id'])): ?>
								<?php echo $n['User']['first_name']; ?>
								<?php else: ?>
								YOU
								<?php endif; ?>
								<div style='font-size:12px; font-style:italic;'>
									<?php echo $this->Time->niceShort($n['created']); ?>
								</div>
							</td>
							<td valign='top'>
								<?php echo nl2br($n['message']); ?>
							</td>
						</tr>
					</table>
				</div>
				<?php endforeach; ?>
			<?php else: ?>
				<div class='no-notes-div'>NO NOTES HAVE BEEN ATTACHED TO THIS ORDER</div>
			<?php endif; ?>
		</div>
	</div>
	
</div>
<?php //print_r($order); ?>