<script>

$(document).ready(function() { 


	$("#orders-table tbody tr").hover(
		function() { 

				$(this).addClass("row-over");

		},
		function() { 

				$(this).removeClass("row-over");

		}
	);
	
});

</script>
<style>
.row-over td {

	background-color:#b2fffe;

}
</style>
<table cellspacing='0' style='font-size:14px;' id='orders-table'>
		<tr>
			<?php if($this->params['controller'] == "canteen_orders"): ?>
			<th><input type='checkbox' id='check-all' /></th>
			<?php endif; ?>
			<th><?php echo $this->Paginator->sort("Order ID","CanteenOrder.id")?></th>
			<th><?php echo $this->Paginator->sort("Order Status","CanteenOrder.order_status");?></th>
			<th><?php echo $this->Paginator->sort("Shipping Status","CanteenOrder.shipping_status");?></th>
			<th><?php echo $this->Paginator->sort("WH Status","CanteenOrder.wh_status");?></th>
			<th><?php echo $this->Paginator->sort("Created","CanteenOrder.created")?></th>
			<th><?php echo $this->Paginator->sort("Modified","CanteenOrder.modified")?></th>
			<th>ShipName / BillName</th>
			<th>Country (S/B/G)</th>
			<th><?php echo $this->Paginator->sort("Currency","CanteenOrder.currency_id"); ?></th>
			<th><?php echo $this->Paginator->sort("ShippingTotal","CanteenOrder.shipping_total"); ?></th>
			<th><?php echo $this->Paginator->sort("TaxTotal","CanteenOrder.tax_total"); ?></th>
			<th><?php echo $this->Paginator->sort("Total","CanteenOrder.total")?></th>
			<th>-</th>
		</tr>
		<tbody>
		<?php 
			foreach($orders as $o):
				$style = '';

				switch(strtolower($o['CanteenOrder']['order_status'])) {
					
					case "approved":
						$style = "background-color:#9fffce;";
					break;
					case "declined":
						$style='background-color:black; color:white;';
					break;
					case "authorized":
						$style='background-color:#f2ffb8;';
					break;
					case "pending":
						$style='background-color:navy; color:white;';
					break;
					case "canceled":
						$style='background-color:yellow; color:black;';
					break;
					case "processing":
						$style='background-color:orange; color:black;';
					break;
				}
				
				$wh_style = '';
				
				switch(strtolower($o['CanteenOrder']['wh_status'])) {
					
					case "approved":
						$wh_style = "background-color:#9fffce;";
					break;
					case "declined":
						$wh_style='background-color:black; color:white;';
					break;
					case "authorized":
						$wh_style='background-color:#f2ffb8;';
					break;
					case "pending":
						$wh_style='background-color:navy; color:white;';
					break;
					case "canceled":
						$wh_style='background-color:yellow; color:black;';
					break;
					case "processing":
						$wh_style='background-color:orange; color:black;';
					break;
					
					
				}
				
				$sh_style = '';
				
				switch(strtolower($o['CanteenOrder']['shipping_status'])) {
					
					case "approved":
						$sh_style = "background-color:#9fffce;";
					break;
					case "declined":
						$sh_style='background-color:black; color:white;';
					break;
					case "authorized":
						$sh_style='background-color:#f2ffb8;';
					break;
					case "pending":
						$sh_style='background-color:navy; color:white;';
					break;
					case "canceled":
						$sh_style='background-color:yellow; color:black;';
					break;
					case "processing":
						$sh_style='background-color:orange; color:black;';
					break;
					
				}
				
			
		?>
		<tr >
			<?php if($this->params['controller'] == "canteen_orders"): ?>
			<td align='center' width='1%'><input type='checkbox' class='order-check' value='<?php echo $o['CanteenOrder']['id']; ?>'/></td>
			<?php  endif; ?>
			<td style='font-size:9px;' nowrap width='1%'><?php echo strtoupper($o['CanteenOrder']['id']); ?></td>
			<td style='<?php echo $style; ?>' nowrap width='1%' align='center'><?php echo strtoupper($o['CanteenOrder']['order_status']); ?></td>
			<td nowrap width='1%' align='center' style='<?php echo $sh_style; ?>'><?php echo strtoupper($o['CanteenOrder']['shipping_status']); ?></td>
			<td nowrap width='1%' align='center' style='<?php echo $wh_style; ?>' ><?php echo strtoupper($o['CanteenOrder']['wh_status']); ?></td>
			<td nowrap width='1%' align='center'><?php echo $this->Time->niceShort($o['CanteenOrder']['created']); ?></td>
			<td nowrap width='1%' align='center'><?php echo $this->Time->niceShort($o['CanteenOrder']['modified']); ?></td>
			<td align='center'>
				<?php echo $o['CanteenOrder']['first_name']; ?> <?php echo $o['CanteenOrder']['last_name']; ?> / 
				<?php echo $o['CanteenOrder']['bill_first_name']; ?> <?php echo $o['CanteenOrder']['bill_last_name']; ?>
			</td>
			<td nowrap width='1%' align='center'>
				<?php echo $o['CanteenOrder']['country']; ?>/<?php echo $o['CanteenOrder']['bill_country']; ?>/<?php echo $o['CanteenOrder']['geoip_country_code']; ?>
			</td>
			<td nowrap width='1%' align='center'>
				<?php echo $o['CanteenOrder']['currency_id']; ?>
			</td>
			<td nowrap width='1%' align='center'>
				<?php echo $o['CanteenOrder']['shipping_total']; ?>
			</td>
			<td nowrap width='1%' align='center'>
				<?php echo $o['CanteenOrder']['tax_total']; ?>
			</td>
			<td nowrap width='1%' align='center'>
				<?php echo $o['CanteenOrder']['total']; ?>
			</td>
			<td class='actions'>
				<a href='/canteen_orders/edit/<?php echo $o['CanteenOrder']['id']; ?>/<?php echo base64_encode($this->here); ?>'>Edit</a>
				<?php 
					if($this->params['controller'] == "canteen_batches"):
				?>
					<a href='/canteen_batches/remove_order/<?php echo $batch['CanteenBatch']['id']; ?>/<?php echo $o['CanteenOrder']['id']; ?>' onclick='return confirm("Are you sure you want to remove this order?");'>Remove From Batch</a>
				<?php 
					endif;
				?>
			</td>
		</tr>
		<?php 
			endforeach;
		?>
		</tbody>
	</table>