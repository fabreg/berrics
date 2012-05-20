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
			<div class='order-notes-help'></div>
			<div class='order-notes-form'>
				<?php 
					echo $this->Form->create("CanteenOrderNote",array("url"=>$this->here));
					echo $this->Form->input("action",array("value"=>"customer_note","type"=>"hidden"));
					echo $this->Form->input("canteen_order_id",array("type"=>"hidden","value"=>$order['CanteenOrder']['id']));
					echo $this->Form->input("message");
					echo $this->Form->submit("Add Note");
					echo $this->Form->end();
				?>
			</div>
			<div style='clear:both;'></div>
			
		</div>
	</div>
	
</div>
<?php print_r($order); ?>