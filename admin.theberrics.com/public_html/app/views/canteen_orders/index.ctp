<style>
.order-table {

}

.index table td {

	font-size:11px;

}
</style>
<div class='index'>
	<h2>Canteen Orders</h2>
	<table cellspacing='0' class='order-table'>
		<tr>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th><?php echo $this->Paginator->sort("created"); ?></th>
			<th><?php echo $this->Paginator->sort("modified"); ?></th>
			<th><?php echo $this->Paginator->sort("order_status"); ?></th>
			<th>Shipments</th>
			<th>ShipTo</th>
			<th><?php echo $this->Paginator->sort("currency_id"); ?></th>
			<th><?php echo $this->Paginator->sort("grand_total"); ?></th>
			<th>-</th>
		</tr>
		<?php foreach($orders as $o): 
		
			$shipto = Set::extract("/UserAddress[address_type=shipping]",$o);	
			
		?>
		<tr>
			<td width='1%' nowrap align='center'><?php echo $o['CanteenOrder']['id']; ?></td>
			<td width='1%' nowrap align='center'><?php echo $this->Time->niceShort($o['CanteenOrder']['created']); ?></td>
			<td width='1%' nowrap align='center'><?php echo $this->Time->niceShort($o['CanteenOrder']['modified']); ?></td>
			<td width='1%' nowrap align='center'><?php echo strtoupper($o['CanteenOrder']['order_status']); ?></td>
			<td width='1%' nowrap align='center'>
			<?php 
				if(count($o['CanteenShippingRecord'])>0):
					foreach($o['CanteenShippingRecord'] as $k=>$s):
			?>
				<div><a href='/canteen_shipping_records/edit/<?php echo $s['id']; ?>' target='_blank'><?php echo strtoupper($s['shipping_status']); ?> (<?php echo $k+1; ?> of <?php echo count($o['CanteenShippingRecord']); ?>)</a></div>
			<?php 
					endforeach;
				endif;
			?>
			</td>
			<td align='center'>
				<?php if(isset($shipto[0]['UserAddress'])): ?>
				<?php echo $shipto[0]['UserAddress']['first_name']; ?> <?php echo $shipto[0]['UserAddress']['last_name']; ?> 
				(<?php echo $shipto[0]['UserAddress']['country_code']; ?>)
				<?php endif; ?>
			</td>
			<td width='1%' nowrap align='center'><?php echo $o['CanteenOrder']['currency_id']; ?></td>
			<td width='1%' nowrap align='center'><?php echo number_format($o['CanteenOrder']['grand_total'],2); ?></td>
			<td class='actions'>
				<a href='/canteen_orders/edit/<?php echo $o['CanteenOrder']['id']; ?>'>Edit</a>
				<a href='/canteen_orders/print_order/<?php echo $o['CanteenOrder']['id']; ?>' target='_blank'>Print Receipt</a>
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
</div>