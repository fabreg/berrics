<?php 

$this->layout="ajax";

 ?>
<table cellspacing='0'>
	<thead>
		<tr>
			<td>Shipment ID</td>
			<td>Order ID</td>
			<td>Last Updated</td>
			<td>Name</td>
			<td>Address</td>
			<td>Tracking</td>
		</tr>
	</thead>
	<?php foreach ($shipments as $k => $v): ?>
		<tr>
			<td>
				<a href='//cp.theberrics.com/canteen_shipping_records/edit/<?php echo $v['CanteenShippingRecord']['id'] ?>'><?php echo $v['CanteenShippingRecord']['id'] ?></a>
			</td>
			<td>
				<a href='//cp.theberrics.com/canteen_orders/edit/<?php echo $v['CanteenShippingRecord']['canteen_order_id'] ?>'><?php echo $v['CanteenShippingRecord']['canteen_order_id'] ?></a>
			</td>
			<td>
				<?php echo $v['CanteenShippingRecord']['modified']; ?>
			</td>
			<td>
				<?php echo $v['UserAddress']['first_name']; ?> <?php echo $v['UserAddress']['last_name']; ?>
			</td>
			<td>
				<?php echo $v['UserAddress']['street'];  ?> <?php echo $v['UserAddress']['apt'];  ?> <?php echo $v['UserAddress']['city'];  ?>  <?php echo $v['UserAddress']['state'];  ?> <?php echo $v['UserAddress']['postal_code'];  ?>  <?php echo $v['UserAddress']['country_code'];  ?> 
			</td>
			<td>
				<?php 
					if (empty($v['CanteenShippingRecord']['tracking_number'])) {
						$tn = $v['CanteenShippingRecord']['shipment_number'];
					} else {
						$tn = $v['CanteenShippingRecord']['tracking_number'];
					}
					
				 ?>
				 <a href='https://tools.usps.com/go/TrackConfirmAction_input?qtc_tLabels1=<?php echo $tn; ?>'><?php echo $tn ?></a>
			</td>
		</tr>
	<?php endforeach ?>
</table>