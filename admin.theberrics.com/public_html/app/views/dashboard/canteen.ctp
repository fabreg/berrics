<?php 

echo $this->element("dashboard/tab-nav");

?>
<style>
.canteen-scroll-box {

	height:400px;
	background-color:#6f8591;
		-webkit-border-radius: 10px;
	border-radius: 10px;
	border:1px solid #e9e9e9;
	-webkit-box-shadow: 1px 1px 5px 2px #999;
	box-shadow: 1px 1px 5px 2px #999;
	
}

.canteen-scroll-box .heading {
	font-weight:bold;
	font-size:18px;
	line-height:35px;
	color:#f7f7f7;
	text-align:center;
}

.canteen-scroll-box .content {
	width:97%;
	margin:auto;
	overflow:auto;
	height:350px;
	-webkit-border-radius: 10px;
	border-radius: 10px;
	background-color:white;
	border:1px solid #e9e9e9;
}
</style>
<script>
function handleNoteReply() {

	var ref = document.location.href;

	document.location.href = ref+"?"+Math.floor(Math.random()*11);
	
}
</script>
<div class='index form'>
	<div>
		<div style='float:right; width:68%;'>
			<div>
				<h2>Customer Notes Requiring Feedback (<?php echo count($customer_notes); ?>)</h2>
					<table cellspacing='0'>
						<tr>
							<th>Created</th>
							<th>Status</th>
							<th>Name</th>
							<th>Order</th>
							<th>Message</th>
							<th>-</th>
						</tr>
						<?php foreach($customer_notes as $k=>$note): 
						
							$n = $note['CanteenOrderNote'];
						
						?>
						<tr>
							
							<td width='1%' nowrap ><?php echo $this->Time->niceShort($n['created']); ?></td>
							<td width='1%'><?php echo strtoupper($n['note_status']); ?></td>
							<td>
								<?php if(isset($n['User']['id'])): ?>
									<?php echo $n['User']['first_name']; ?> <?php echo $n['User']['last_name']; ?>
								<?php else: ?>
									CUSTOMER
								<?php endif; ?>
							</td>
							<td><a href='/canteen_orders/edit/<?php echo $n['canteen_order_id']; ?>'><?php echo $n['canteen_order_id']; ?></a></td>
							<td><?php echo nl2br($n['message']); ?></td>
							<td class='actions'>
								<a href='javascript:CanteenOrderNote.reply(<?php echo $n['id']; ?>,"handleNoteReply");'>Quick Reply</a>
							</td>
						</tr>
						<?php endforeach; ?>
					</table>
			</div>
			
		</div>
		<div style='float:left; width:30%;'>
			<div>
				<fieldset>
					<legend>Shipments in Pending</legend>
					<div style='font-size:60px; font-weight:bold; text-align:center; width:45%; float:right;'>
						<a href='/canteen_shipping_records/index/s:1/CanteenShippingRecord.shipping_status:pending' target='_blank'><?php echo $pending_shipments; ?></a>
					</div>
					<div style='width:45%; float:left;'>
						<a href='/canteen_shipping_records/index/s:1/CanteenShippingRecord.shipping_status:pending/CanteenShippingRecord.warehouse_id:1' target='_blank'>View Berrics Warehouse</a>
					</div>
					<div style='clear:both;'></div>
				</fieldset>
				<fieldset>
					<legend>Shipments in Processing</legend>
					<div style='font-size:60px; font-weight:bold; text-align:center;'>
						<a href='/canteen_shipping_records/index/s:1/CanteenShippingRecord.shipping_status:processing'><?php echo $processing_shipments; ?></a>
					</div>
				</fieldset>
				<fieldset>
					<legend>Orders Today</legend>
					<div>
						<div style='float:left; width:44%;'>
							<table cellspacing='0'>
								<?php  $total = 0;  
								
									if(count($orders_today)>0):
									
								?>
								<tr>
									<th>Status</th>
									<th>Count</th>
								</tr>
								<?php foreach($orders_today as $k=>$v): $total += $v[0]['total']; ?>
								<tr>
									<td width='1%'>
										<?php echo strtoupper($v['CanteenOrder']['order_status']); ?>
									</td>
									<td>
										<?php echo $v[0]['total']; ?>
									</td>
								</tr>
								<?php endforeach; ?>
								
								<?php endif; ?>
							</table>
						</div>
						<div style='float:right; width:44%;'>
							<div style='font-size:60px; font-weight:bold; text-align:center;'>
								<a href='/canteen_orders/index'><?php echo $total; ?></a>
							</div>
						</div>
						<div style='clear:both;'></div>
					</div>
				</fieldset>
				<fieldset>
					<legend>Orders Past 30 days</legend>
					<div>
						<div style='float:left; width:44%;'>
							<table cellspacing='0'>
								<?php  $total = 0;  
								
									if(count($orders_month)>0):
									
								?>
								<tr>
									<th>Status</th>
									<th>Count</th>
								</tr>
								<?php foreach($orders_month as $k=>$v): $total += $v[0]['total']; ?>
								<tr>
									<td width='1%'>
										<?php echo strtoupper($v['CanteenOrder']['order_status']); ?>
									</td>
									<td>
										<?php echo $v[0]['total']; ?>
									</td>
								</tr>
								<?php endforeach; ?>
								
								<?php endif; ?>
							</table>
						</div>
						<div style='float:right; width:44%;'>
							<div style='font-size:60px; font-weight:bold; text-align:center;'>
								<a href='/canteen_shipping_records/index/s:1/shipping_status:processing'><?php echo $total; ?></a>
							</div>
						</div>
						<div style='clear:both;'></div>
					</div>
				</fieldset>
			</div>	
		</div>
		<div style='clear:both;'></div>
	</div>
</div>
<?php 

print_r($orders_month);

?>