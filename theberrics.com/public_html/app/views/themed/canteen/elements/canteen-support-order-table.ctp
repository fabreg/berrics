<?php 



?>

<?php if(count($orders)>0): ?>
<h2>Viewing <?php echo count($orders); ?> Previous Order(s)</h2>	
	<table cellspacing='0' class='canteen-table-items'>
		<tr>
			<th>-</th>
			<th>Order ID</th>
			<th>Order Date</th>
			<th>Actions</th>
		</tr>
		<?php 
			foreach($orders as $o):
		?>
		<tr>
			<td>&nbsp;</td>
			<td align='center'><?php echo $o['CanteenOrder']['id']; ?></td>
			<td align='center'><?php echo $this->Time->niceShort($o['CanteenOrder']['created']); ?></td>
			<td align='center' class='actions'>
				<a href='/canteen/order/<?php echo $o['CanteenOrder']['hash']; ?>' target='_blank'>View Order Status</a>
			</td>
		</tr>
		<?php 
			endforeach;
		?>
	</table>
<?php else: ?>
<h2 style='text-align:center; padding:15px;'>No Orders Where Found</h2>
<?php endif; ?>