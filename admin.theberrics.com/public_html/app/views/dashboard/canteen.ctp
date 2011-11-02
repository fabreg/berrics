<?php 

echo $this->element("dashboard/tab-nav");

?>
<div class='index'>
	<div style='width:33%; float:left;'>
		<div class='round-div'>
			<div class='header'>Orders: Today</div>
			<table cellspacing='0'>
				<tr>
					<th colspan='2' align='left'>
						Order Status
					</th>
				</tr>
				<?php foreach($today_order_status as $v): ?>
				<tr>
					<td width='1%'><?php echo strtoupper($v['CanteenOrder']['order_status']); ?></td>
					<td><?php echo	$v[0]['total']; ?></td>
				</tr>
				
				<?php endforeach; ?>
			</table>
			<div style='height:15px'></div>
			<table cellspacing='0'>
				<tr>
					<th colspan='2' align='left'>
						Shipping Status
					</th>
				</tr>
				<?php foreach($today_shipping_status as $v): ?>
				<tr>
					<td width='1%'><?php echo strtoupper($v['CanteenOrder']['shipping_status']); ?></td>
					<td><?php echo	$v[0]['total']; ?></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>
		<div class='round-div'>
			<div class='header'>Orders: <?php echo $three_day_start; ?> - <?php echo $three_day_end; ?></div>
			<table cellspacing='0'>
				<tr>
					<th colspan='2' align='left'>
						Order Status
					</th>
				</tr>
				<?php foreach($today_order_status as $v): ?>
				<tr>
					<td width='1%'><?php echo strtoupper($v['CanteenOrder']['order_status']); ?></td>
					<td><?php echo	$v[0]['total']; ?></td>
				</tr>
				
				<?php endforeach; ?>
			</table>
			<div style='height:15px'></div>
			<table cellspacing='0'>
				<tr>
					<th colspan='2' align='left'>
						Shipping Status
					</th>
				</tr>
				<?php foreach($today_shipping_status as $v): ?>
				<tr>
					<td width='1%'><?php echo strtoupper($v['CanteenOrder']['shipping_status']); ?></td>
					<td><?php echo	$v[0]['total']; ?></td>
				</tr>
				<?php endforeach; ?>
			</table>
		</div>		
	</div>
	<div style='width:33%; float:left;'>
		
	</div>
	<div style='width:33%; float:left;'>
	
	</div>
	<div style='clear:both;'></div>
</div>