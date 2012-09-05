<script>
$(document).ready(function() { 


	$('input[name=checkall]').change(function() { 

		if($(this).is(":checked")) {

			$('.record_check').attr({"checked":true});
			
		} else {

			$('.record_check').attr({"checked":false});

		}

	});

	$('input[name=process_print_batch]').click(function() { 

		setBatchCommand('process_usps_print');

	});
	$('input[name=usps_print]').click(function() { 

		setBatchCommand('usps_print');

	});
	
});

function setBatchCommand(cmd) {

	$('#checkbox_form').append('<input type="hidden" name="data[Command]" value="'+cmd+'"/>').submit();
	
}

</script>
<style>


.index table td {

	font-size:11px;

}

</style>
<div class='index'>
	<h2>Canteen Shipping Records</h2>
	<div class='form'>
		
		<div style='float:left; width:40%;'>
			<fieldset>
				<legend>Filter</legend>
				<?php 
					echo $this->Form->create("CanteenShippingRecord",array("url"=>"/canteen_shipping_records/search"));
				?>
				<div>
					<?php 
						echo $this->Form->input("id",array("label"=>"Shipment ID","type"=>"text"));
					?>
				</div>
				<div style='float:left;'>
					<?php 
						echo $this->Form->input("warehouse_id",array("options"=>$whSelect,"empty"=>true));
					?>
				</div>
				<div style='float:left;'>
					<?php 
						echo $this->Form->input("shipping_status",array("options"=>$statusSelect,"empty"=>true));
					?>
				</div>
				<div style='clear:both;'></div>
				<?php 
					echo $this->Form->end("GO");
				?>
			</fieldset>
		</div>
		<div style='float:left; width:40%; margin-left:10px;'>
			<fieldset>
				<legend>Batch Operations</legend>
				<div>
					<input type='button' value='Process & Print USPS Shipments' name='process_print_batch' />
					<input type='button' value='Print USPS Shipments' name='usps_print' />
				</div>
			</fieldset>
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
	<?php 
		echo $this->Form->create("CanteenShippingRecord",array("url"=>"/canteen_shipping_records/batch_operation",'id'=>'checkbox_form'));
	?>
	<table cellspacing='0'>
		<tr>
			<th>
				<input type='checkbox' value='1' name='checkall' />
			</th>
			<th><?php echo $this->Paginator->sort("id"); ?></th>
			<th><?php echo $this->Paginator->sort("created"); ?></th>
			<th><?php echo $this->Paginator->sort("modified"); ?></th>
			<th><?php echo $this->Paginator->sort("shipping_status"); ?></th>
			<th><?php echo $this->Paginator->sort("Warehouse.name"); ?></th>
			<th><?php echo $this->Paginator->sort("carrier_name"); ?></th>
			<th><?php echo $this->Paginator->sort("tracking_number");?>
			<th>-</th>
		</tr>
		<?php foreach($records as $v): 
			$s = $v['CanteenShippingRecord'];
			$w = $v['Warehouse'];
			$u = $v['UserAddress'];
			$o = $v['CanteenOrder'];
		?>
		<tr>
			<td>
				<?php if((strtoupper($s['shipping_status']) == "PENDING") || (isset($this->params['named']['CanteenShippingRecord.shipping_status']))): ?>
				<input type='checkbox' value='<?php echo $s['id']; ?>' name='data[canteen_shipping_record_id][]'  class='record_check' />
				<?php endif; ?>
			</td>
			<td><?php echo $s['id']; ?></td>
			<td><?php echo $this->Time->niceShort($s['created']); ?></td>
			<td><?php echo $this->Time->niceShort($s['modified']); ?></td>
			<td><?php 
				
				$color = "green";
				switch(strtoupper($s['shipping_status'])) {
					
					case "PENDING";
						$color="orange";
						break;
					case "PROCESSING";
						$color="blue";
						break;
					case "SHIPPED":
						$color="green";
						break;
					case "CANCELED":
						$color="grey";
						break;
					
				}
			
				echo "<span style='color:{$color}; font-weight:bold; font-size:14px;'>";
				echo strtoupper($s['shipping_status']);
				echo "</span>";
				?>
				</td>
			<td style='font-size:14px; font-weight:bold;'><?php echo $w['name']; ?></td>
			<td><?php echo $s['carrier_name']; ?></td>
			<td>
				<?php if(strtoupper($s['carrier_name']) == "USPS"): ?>
						<?php 
						
						$tnum = $s['tracking_number'];
						
						if(empty($s['tracking_number'])) {
							
							$tnum = $s['shipment_number'];
							
						}
						
						?>
						<a href='http://trkcnfrm1.smi.usps.com/PTSInternetWeb/InterLabelInquiry.do?origTrackNum=<?php echo $tnum; ?>' target='_blank'><?php echo $tnum; ?></a>
				<?php elseif(strtoupper($s['carrier_name'])=="UPS"): ?>
						<a  target='_blank' href='http://wwwapps.ups.com/WebTracking/track?track=yes&trackNums=<?php echo $s['tracking_number']; ?>'><?php echo $s['tracking_number']; ?></a>
				<?php endif; ?>
			</td>
			<td class='actions'>
				<a href='/canteen_shipping_records/edit/<?php echo $s['id']; ?>/callback:<?php echo base64_encode($this->here); ?>'>Edit</a>
				<?php if(strtoupper($s['shipping_status'])=="PENDING"): ?>
					<a href='/canteen_shipping_records/process_usps_shipment/<?php echo $s['id']; ?>/calback:<?php echo base64_encode($this->here); ?>'>USPS Shipment</a>
				<?php endif; ?>
				<?php if(strtoupper($s['shipping_status'])=="PROCESSING"): ?>
					<a href='/canteen_shipping_records/process_usps_shipment/<?php echo $s['id']; ?>/calback:<?php echo base64_encode($this->here); ?>' onclick='return confirm("Are you sure you want to regenerate this shipment");' >Regenerate USPS Shipment</a>
					<a href='/canteen_shipping_records/usps_combo_label/<?php echo $s['id']; ?>/calback:<?php echo base64_encode($this->here); ?>' >Print USPS Combo Label</a>
					<a href='/canteen_shipping_records/checkout_shipment/<?php echo $s['id']; ?>/<?php echo base64_encode($this->here); ?>'>Checkout Shipment</a>
				<?php endif; ?>
				
			</td>
		</tr>
		<?php endforeach; ?>
	</table>
	<?php 
		echo $this->Form->end();
	?>
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