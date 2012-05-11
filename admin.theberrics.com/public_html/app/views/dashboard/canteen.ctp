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
						<th>ID</th>
						<th>Date</th>
						<th>Order</th>
						<th>Message</th>
						<th>-</th>
					</tr>
					<?php foreach($customer_notes as $note): ?>
					<tr>
						<td><?php echo $note['CanteenOrderNote']['id']; ?></td>
						<td><?php echo $this->Time->niceShort($note['CanteenOrderNote']['created']); ?></td>
						<td><a href='/canteen_orders/edit/<?php echo $note['CanteenOrderNote']['canteen_order_id']; ?>'><?php echo $note['CanteenOrderNote']['canteen_order_id']; ?></a></td>
						<td><?php echo $note['CanteenOrderNote']['message']; ?></td>
						<td class='actions'>
							<a href=''>Reply</a>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
		</div>
		<div style='float:right; width:48%;'>
			<div>
				<h2>Pending Shipments ()</h2>
				<h2>Shipments in Processing ()</h2>
			</div>
			<div>
				<h2>Order Stats ( Today )</h2>
				
			</div>
			<div>
				<h2>Order Stats ( Previous 30 Days )</h2>
			</div>
		</div>
		<div style='clear:both;'></div>
	</div>
</div>
<?php 

print_r($customer_notes);

?>