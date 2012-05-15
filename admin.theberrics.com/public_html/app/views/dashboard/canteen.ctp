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
<div class='index'>
	<div>
		<div style='float:left; width:48%;'>
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
							
							<td width='1%'><?php echo $this->Time->niceShort($n['created']); ?></td>
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
								<a href='javascript:CanteenOrderNote.reply(<?php echo $n['id']; ?>);'>Quick Reply</a>
							</td>
						</tr>
						<?php endforeach; ?>
					</table>
			</div>
			<div>
				<h2>Order Stats ( Today )</h2>
				<?php if(count($orders_today)>0): ?>
				<table cellspacing='0'>
					<tr>
						<th>Status</th>
						<th>Count</th>
					</tr>
					<?php foreach($orders_today as $k=>$v): ?>
					<tr>
						<td width='1%'>
							<?php echo strtoupper($v['CanteenOrder']['order_status']); ?>
						</td>
						<td>
							<?php echo $v[0]['total']; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
				<?php else: ?>
				NO ORDERS TODAY
				<?php endif; ?>
			</div>
			<div>
				<h2>Order Stats ( Previous 30 Days )</h2>
				<?php if(count($orders_month)>0): ?>
				<table cellspacing='0'>
					<tr>
						<th>Status</th>
						<th>Count</th>
					</tr>
					<?php foreach($orders_month as $k=>$v): ?>
					<tr>
						<td  width='1%'>
							<?php echo strtoupper($v['CanteenOrder']['order_status']); ?>
						</td>
						<td>
							<?php echo $v[0]['total']; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
				<?php else: ?>
				NO ORDERS TODAY
				<?php endif; ?>
			</div>
		</div>
		<div style='float:right; width:48%;'>
			<div>
				<h2>Shipments in Pending (<?php echo $pending_shipments; ?>)</h2>
				<h2>Shipments in Processing (<?php echo $processing_shipments; ?>)</h2>
			</div>
			
		</div>
		<div style='clear:both;'></div>
	</div>
</div>
<?php 

print_r($customer_notes);

?>