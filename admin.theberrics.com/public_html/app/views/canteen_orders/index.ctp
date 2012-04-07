<div class='index'>
	<h2>Canteen Orders</h2>
	<table cellspacing='0'>
		<tr>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th><?php echo $this->Paginator->sort("created"); ?></th>
			<th><?php echo $this->Paginator->sort("modified"); ?></th>
			<th><?php echo $this->Paginator->sort("order_status"); ?></th>
			<th><?php echo $this->Paginator->sort("fulfillment_status"); ?></th>
			<th><?php echo $this->Paginator->sort("shipping_status"); ?></th>
			<th>-</th>
		</tr>
		<?php foreach($orders as $o): ?>
		<tr>
			<td><?php echo $o['CanteenOrder']['id']; ?></td>
			<td><?php echo $this->Time->niceShort($o['CanteenOrder']['created']); ?></td>
			<td><?php echo $this->Time->niceShort($o['CanteenOrder']['modified']); ?></td>
			<td><?php echo strtoupper($o['CanteenOrder']['order_status']); ?></td>
			<td><?php echo strtoupper($o['CanteenOrder']['fulfillment_status']); ?></td>
			<td><?php echo strtoupper($o['CanteenOrder']['shipping_status']); ?></td>
			<td class='actions'>
				<a href='/canteen_orders/edit/<?php echo $o['CanteenOrder']['id']; ?>'>Edit</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>