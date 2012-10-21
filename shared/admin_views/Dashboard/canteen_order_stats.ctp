<h3>Orders This Month</h3>
<table cellspacing='0'>
	<?php foreach($orders_month as $o): ?>
	<tr>
		<td><?php echo ucfirst($o['CanteenOrder']['order_status']); ?></td>
		<td><?php echo number_format($o[0]['total']); ?></td>
	</tr>
	<?php endforeach; ?>
</table>