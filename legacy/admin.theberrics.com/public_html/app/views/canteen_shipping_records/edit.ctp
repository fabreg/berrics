<?php 

$v = $this->data['UserAddress'];

?>
<style>
.record {

	

}

.record table td:nth-child(odd) {

	font-weight:bold;
	text-align:right;

}
</style>
<div class='form index'>
	<div class='print-link'>
		<a href='/canteen_shipping_records/print_record/<?php echo $this->data['CanteenShippingRecord']['id']; ?>' target='_blank'>
			Print
		</a>
	</div>
	<div>
		<div style='float:left; width:40%;' class='record'>
		<h2>Shipping Record</h2>
		<?php 
			echo $this->Form->create("CanteenShippingRecord",array("url"=>$this->here));
		?>
		<table cellspacing='0'>
			<tr>
				<td>ID</td>
				<td><?php echo $this->data['CanteenShippingRecord']['id']; ?></td>
			</tr>
			<tr>
				<td>Created/Updated</td>
				<td>
				<?php echo $this->Time->niceShort($this->data['CanteenShippingRecord']['created']); ?>/<?php echo $this->Time->niceShort($this->data['CanteenShippingRecord']['modified']); ?>
				</td>
			</tr>
			<tr>
				<td>Shipping Status</td>
				<td><?php echo $this->data['CanteenShippingRecord']['shipping_status']; ?></td>
			</tr>
			<tr>
				<td>Warehouse</td>
				<td><?php echo $this->data['Warehouse']['name']; ?></td>
			</tr>
			<tr>
				<td>Foreign Key</td>
				<td><?php echo $this->data['CanteenShippingRecord']['foreign_key']; ?></td>
			</tr>
			<tr>
				<td>Carrier Name</td>
				<td><?php echo $this->data['CanteenShippingRecord']['carrier_name']; ?></td>
			</tr>
			<tr>
				<td>Tracking #</td>
				<td><?php echo $this->data['CanteenShippingRecord']['tracking_number']; ?></td>
			</tr>
		</table>
		<?php 
			echo $this->Form->end();
		?>
		<h2>Canteen Order</h2>
		<table cellspacing='0'>
			<tr>
				<td>ID</td>
				<td><?php echo $this->data['CanteenOrder']['id']; ?></td>
			</tr>
			<tr>
				<td>Created/Modified</td>
				<td><?php echo $this->Time->niceShort($this->data['CanteenOrder']['created']); ?>/<?php echo $this->Time->niceShort($this->data['CanteenOrder']['modified']); ?></td>
			</tr>
			<tr>
				<td>Order Status</td>
				<td><?php echo strtoupper($this->data['CanteenOrder']['order_status']); ?></td>
			</tr>
			<tr>
				<td   colspan='2' class='actions' style='text-align:center;' align='center'>
					<a href='/canteen_orders/edit/<?php echo $this->data['CanteenOrder']['id']; ?>'>
						Edit
					</a>
				</td>
			</tr>
		</table>
		</div>
		<div style='float:left; width:40%;'>
		<h2>Shipping Address</h2>
		<table cellspacing='0'>
						<tr>
							<td>Address Type</td>
							<td><?php echo strtoupper($v['address_type']); ?></td>
						</tr>
						<tr>
							<td>First Name</td>
							<td><?php echo $v['first_name']; ?></td>
						</tr>
						<tr>
							<td>Last Name</td>
							<td><?php echo $v['last_name']; ?></td>
						</tr>
						<tr>
							<td>Street</td>
							<td><?php echo $v['street']; ?></td>
						</tr>
						<tr>
							<td>Apt</td>
							<td><?php echo $v['apt']; ?></td>
						</tr>
						<tr>
							<td>City</td>
							<td><?php echo $v['city']; ?></td>
						</tr>
						<tr>
							<td>State/Province</td>
							<td><?php echo $v['state']; ?></td>
						</tr>
						<tr>
							<td>Postal</td>
							<td><?php echo $v['postal_code']; ?></td>
						</tr>
						<tr>
							<td>Country Code</td>
							<td><?php echo $v['country_code']; ?></td>
						</tr>
						<tr>
							<td>Phone</td>
							<td><?php echo $v['phone']; ?></td>
						</tr>
						<tr>
							<td>Email</td>
							<td><?php echo $v['email']; ?></td>
						</tr>
						<tr>
							<td>ID</td>
							<td><?php echo $v['id']; ?></td>
						</tr>
						<tr>
							<td colspan='2' class='actions'>
								<a href='/user_addresses/edit/<?php echo $v['id']; ?>/callback:<?php echo base64_encode($this->here); ?>'>Edit</a>
							</td>
						</tr>
					</table>
		</div>
		<div style='clear:both;'></div>
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
			foreach($this->data['CanteenOrderItem'] as $i):
		?>
			<tr>
				<td><?php echo $i['title']; ?><div><?php echo $i['sub_title']; ?></div></td>
				<td>
				<div><strong>WH: </strong> <?php echo $this->data['Warehouse']['name']; ?></div>
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
</div>
<?php 
pr($this->data);
?>