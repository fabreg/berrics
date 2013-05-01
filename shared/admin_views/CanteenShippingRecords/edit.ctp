<?php 

$v = $this->request->data['UserAddress'];

?>
<style>
.record {

	

}

.record table td:nth-child(odd) {

	font-weight:bold;
	text-align:right;

}
</style>

<div class="row-fluid index">
	<div class="span6">
		<div class='record'>
		<h2>Shipping Record</h2>
		<?php 
			echo $this->Form->create("CanteenShippingRecord",array("url"=>$this->request->here));
		?>
		<table cellspacing='0'>
			<tr>
				<td>ID</td>
				<td><?php echo $this->request->data['CanteenShippingRecord']['id']; ?></td>
			</tr>
			<tr>
				<td>Created/Updated</td>
				<td>
				<?php echo $this->Time->niceShort($this->request->data['CanteenShippingRecord']['created']); ?>/<?php echo $this->Time->niceShort($this->request->data['CanteenShippingRecord']['modified']); ?>
				</td>
			</tr>
			<tr>
				<td>Shipping Status</td>
				<td><?php echo $this->request->data['CanteenShippingRecord']['shipping_status']; ?></td>
			</tr>
			<tr>
				<td>Warehouse</td>
				<td><?php echo $this->request->data['Warehouse']['name']; ?></td>
			</tr>
			<tr>
				<td>Foreign Key</td>
				<td><?php echo $this->request->data['CanteenShippingRecord']['foreign_key']; ?></td>
			</tr>
			<tr>
				<td>Carrier Name</td>
				<td><?php echo $this->request->data['CanteenShippingRecord']['carrier_name']; ?></td>
			</tr>
			<tr>
				<td>Tracking #</td>
				<td>
					<?php if(strtoupper($this->request->data['CanteenShippingRecord']['carrier_name']) == "USPS"): ?>
						<?php 
						
						$tnum = $this->request->data['CanteenShippingRecord']['tracking_number'];
						
						if(empty($this->request->data['CanteenShippingRecord']['tracking_number'])) {
							
							$tnum = $this->request->data['CanteenShippingRecord']['shipment_number'];
							
						}
						
						?>
						<a href='http://trkcnfrm1.smi.usps.com/PTSInternetWeb/InterLabelInquiry.do?origTrackNum=<?php echo $tnum; ?>' target='_blank'><?php echo $tnum; ?></a>
				<?php elseif(strtoupper($this->request->data['CanteenShippingRecord']['carrier_name'])=="UPS"): ?>
						<a  target='_blank' href='http://wwwapps.ups.com/WebTracking/track?track=yes&trackNums=<?php echo $this->request->data['CanteenShippingRecord']['tracking_number']; ?>'><?php echo $this->request->data['CanteenShippingRecord']['tracking_number']; ?></a>
				<?php endif; ?>

				</td>
			</tr>
			<tr>
				<td><strong>Actions</strong></td>
				<td>
					<?php 

						switch(strtoupper($this->request->data['CanteenShippingRecord']['shipping_status'])) {

							case "PENDING":
								echo "<a href='/canteen_shipping_records/process_usps_shipment/".$this->request->data['CanteenShippingRecord']['id']."/callback:".base64_encode($this->here)."' class='btn btn-mini' onclick='return confirm(\"Are you sure you want to generate a shipment?\");'><i class='icon icon-envelope'></i> Ship VIA USPS</a>";
							break;

						}

					 ?>
				</td>
			</tr>
		</table>
		<?php 
			echo $this->Form->end();
		?>
		<h2>Canteen Order</h2>
		<table cellspacing='0'>
			<tr>
				<td>ID</td>
				<td><?php echo $this->request->data['CanteenOrder']['id']; ?></td>
			</tr>
			<tr>
				<td>Created/Modified</td>
				<td><?php echo $this->Time->niceShort($this->request->data['CanteenOrder']['created']); ?>/<?php echo $this->Time->niceShort($this->request->data['CanteenOrder']['modified']); ?></td>
			</tr>
			<tr>
				<td>Order Status</td>
				<td><?php echo strtoupper($this->request->data['CanteenOrder']['order_status']); ?></td>
			</tr>
			<tr>
				<td   colspan='2' class='actions' style='text-align:center;' align='center'>
					<a href='/canteen_orders/edit/<?php echo $this->request->data['CanteenOrder']['id']; ?>'>
						Edit
					</a>
				</td>
			</tr>
		</table>
		</div>
	</div>
	<div class="span6">
		<h2>Shipping Address</h2>
		<?php echo $this->element("canteen_orders/address",array("address"=>$this->request->data['UserAddress'])) ;?>
		<div>
			<a href="/canteen_shipping_records/validate_address/<?php echo $this->request->data['UserAddress']['id']; ?>" class="btn btn-warning"><i class="icon icon-envelope"></i> Validate Address</a>
		</div>
	</div>
</div>
<fieldset>
		<legend>Items</legend>
		<table cellspacing='0'>
			<tr>
				<th>Item</th>
				<th>Warehouse Info</th>
				<th>Qty</th>
				<th>Weight</th>
			</tr>
		<?php 
			foreach($this->request->data['CanteenOrderItem'] as $i):
		?>
			<tr>
				<td><?php echo $i['title']; ?><div><?php echo $i['sub_title']; ?></div></td>
				<td>
				<div><strong>WH: </strong> <?php echo $this->request->data['Warehouse']['name']; ?></div>
				<div><strong>ITEM#: </strong> <?php echo $i['CanteenInventoryRecord']['foreign_key']; ?></div>
				</td>
				<td align='center' width='1%'><?php echo $i['quantity']; ?></td>
				<td align='center' width='1%'><?php echo $i['weight']; ?></td>
			</tr>
		<?php 
			endforeach;
		?>
		</table>
	</fieldset>
<?php 
pr($this->request->data);
?>