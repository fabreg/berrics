
<div id='panel' class='index'>
	<div class='left'>
	<h2>Limelight Video Transfer</h2>
		<table cellspacing='0'>
				<tr>
					<td align='right' width='1%' nowrap>Total Video Files:</td>
					<td><?php echo $videoCount; ?></td>
				</tr>
				<tr>
					<td  align='right' width='1%' nowrap>Total Video Files Transfered To Limelight:</td>
					<td><?php echo $llnwCount; ?></td>
				</tr>
				<tr>
					<td  align='right' width='1%' nowrap>Total Video Files Active Using Limelight:</td>
					<td><?php echo $llnwLive; ?></td>
				</tr>			
		</table>

		<h2>Reports</h2>
		<div>
			<ul>
				<li><?php echo $this->Admin->link("TRAFFIC: Monthly Overview",array("controller"=>"traffic_reports","action"=>"monthly")); ?></li>
				<li><?php echo $this->Admin->link("TRAFFIC: Countries: Monthly Overview",array("controller"=>"traffic_reports","action"=>"country_month_index")); ?></li>
				<li><?php echo $this->Admin->link("TRAFFIC: DMA Codes: Monthly Overview",array("controller"=>"traffic_reports","action"=>"dma_codes")); ?></li>
				<li><?php echo $this->Admin->link("MEDIA: Most Viewed",array("controller"=>"traffic_reports","action"=>"media_files")); ?></li>
				<li><?php echo $this->Admin->link("MEDIA: Realtime View",array("controller"=>"traffic_reports","action"=>"media_realtime")); ?></li>
				<li><?php echo $this->Admin->link("MEDIA: Monthly Overview",array("controller"=>"traffic_reports","action"=>"media_monthly_overview")); ?></li>
			</ul>
		</div>
	</div>
	
	<div class='right'>
		<h2>The Canteen</h2>
		<div>
			<div style='float:left; width:49%;'>
				<table cellspacing='0'>
					<tr>
						<th align='left' width='1%' nowrap colspan='2'>Order Stats - Yesterday</th>
					</tr>
					<?php foreach($ordersYesterday as $s): ?>
					<tr>
						<td align='right' width='1%' nowrap ><?php echo strtoupper($s['CanteenOrder']['order_status']); ?></td>
						<td>
							<a href='/canteen_orders/index/s:1/CanteenOrder.order_status:<?php echo base64_encode($s['CanteenOrder']['order_status']); ?>'><?php echo $s[0]['total']; ?> <span style='font-style:italic;'>(view)</span></a>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
				<table cellspacing='0'>
					<tr>
						<th align='left' width='1%' nowrap colspan='2'>Order Stats - Today</th>
					</tr>
					<?php foreach($ordersToday as $s): ?>
					<tr>
						<td align='right' width='1%' nowrap ><?php echo strtoupper($s['CanteenOrder']['order_status']); ?></td>
						<td>
							<?php echo $s[0]['total']; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
			<div style='float:right; width:49%; '>
				<table cellspacing='0'>
					<tr>
						<th colspan='2' align='left'>Transactions - 3 Days Back</th>
					</tr>
					<?php foreach($approvedTransStats as $s): ?>
					<tr>
						<td align='right' width='1%' nowrap>
							<?php echo strtoupper($s['GatewayTransaction']['method']); ?>
						</td>
						<td><?php echo $s[0]['total']; ?></td>
					</tr>
					<?php endforeach; ?>
				</table>
			</div>
			<div style='clear:both;'></div>
		</div>
		<h2>on.Demand</h2>
		<table cellspacing='0'>
		
		
		</table>
	</div>
	<div style='clear:both;'></div>
</div>
