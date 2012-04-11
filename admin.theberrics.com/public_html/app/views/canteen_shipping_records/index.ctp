<div class='index'>
	<h2>Canteen Shipping Records</h2>
	
	<table cellspacing='0'>
		<tr>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th><?php echo $this->Paginator->sort("created"); ?></th>
			<th><?php echo $this->Paginator->sort("modified"); ?></th>
			<th><?php echo $this->Paginator->sort("shipping_status"); ?></th>
			<th><?php echo $this->Paginator->sort("Warehouse.name"); ?></th>
			<th><?php echo $this->Paginator->sort("carrier_name"); ?></th>
			<th>-</th>
		</tr>
		<?php foreach($records as $v): 
			$s = $v['CanteenShippingRecord'];
			$w = $v['Warehouse'];
			$u = $v['UserAddress'];
			$o = $v['CanteenOrder'];
		?>
		<tr>
			<td><?php echo $s['id']; ?></td>
			<td><?php echo $this->Time->niceShort($s['created']); ?></td>
			<td><?php echo $this->Time->niceShort($s['modified']); ?></td>
			<td><?php echo strtoupper($s['shipping_status']); ?></td>
			<td><?php echo $w['name']; ?></td>
			<td><?php echo $s['carrier_name']; ?></td>
			<td class='actions'>
				<a href='/canteen_shipping_records/edit/<?php echo $s['id']; ?>/callback:<?php echo base64_encode($this->here); ?>'>Edit</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>