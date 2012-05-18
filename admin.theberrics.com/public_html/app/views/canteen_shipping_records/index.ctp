<div class='index'>
	<h2>Canteen Shipping Records</h2>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
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
				<?php if(strtoupper($s['shipping_status'])=="PENDING"): ?>
				<a href='/canteen_shipping_records/process_usps_shipment/<?php echo $s['id']; ?>/calback:<?php echo base64_encode($this->here); ?>'>USPS Shipment</a>
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>