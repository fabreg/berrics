<?php 

//pr($this->params);

?>
<style>
.order-table {

}

.index table td {

	font-size:11px;

}
.search-bit {

	float:left;
	margin:3px;
	padding:5px;
	line-height:15px;
	font-size:12px;
	border:1px solid #999;
	background-color:#e0e0e0;
	-webkit-border-radius: 10px;
-moz-border-radius: 10px;
border-radius: 10px;

}

</style>
<div class='index'>
	<h2>Canteen Orders</h2>
	<div style='padding:10px;'>
		<div>
			<ul>
				<li>
					<a href='/canteen_orders/search'>Search Orders</a>
				</li>
			</ul>
		</div>
		<div>
		<?php if(count($this->params['named'])>0): ?>
		<fieldset>
			<legend>Search Conditions</legend>
			<div>
				<?php 
					
					foreach($this->params['named'] as $k=>$v): 
						if(!preg_match('/^(CanteenOrder|UserAddress)\./',$k)) continue;
						$v = base64_decode($v);
				?>
					<div class='search-bit'>
						<?php echo "<strong>{$k}</strong> : {$v}"; ?>
					</div>
				<?php endforeach; ?>
				<div style='clear:both;'></div>
			</div>
		</fieldset>
		<?php endif; ?>
		</div>
		<div style='clear:both;'></div>
	</div>
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
	<table cellspacing='0' class='order-table'>
		<tr>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th><?php echo $this->Paginator->sort("created"); ?></th>
			<th><?php echo $this->Paginator->sort("modified"); ?></th>
			<th><?php echo $this->Paginator->sort("order_status"); ?></th>
			<th>Shipments</th>
			<th>ShipTo</th>
			<th>BillTo</th>
			
			<th><?php echo $this->Paginator->sort("currency_id"); ?></th>
			<th><?php echo $this->Paginator->sort("grand_total"); ?></th>
			
			<th>-</th>
		</tr>
		<?php foreach($orders as $o): 
		
			$shipto = Set::extract("/UserAddress[address_type=shipping]",$o);	
			$billto = Set::extract("/UserAddress[address_type=billing]",$o);
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
				<?php echo $o['ShippingAddress']['first_name']; ?> <?php echo $o['ShippingAddress']['last_name']; ?> 
				(<?php echo $o['ShippingAddress']['country_code']; ?>)
				<br />
				<?php echo $o['ShippingAddress']['email']; ?>
				
			</td>
			<td align='center'>
				
				<?php echo $o['BillingAddress']['first_name']; ?> <?php echo $o['BillingAddress']['last_name']; ?> 
				(<?php echo $o['BillingAddress']['country_code']; ?>)<br />
				
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