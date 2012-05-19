<?php 

$data = unserialize($msg['EmailMessage']['serialized_data']);

$csr = ClassRegistry::init("CanteenShippingRecord");

$record = $csr->returnAdminRecord($data['canteen_shipping_record_id']);

unset($csr);

?>
<div>
	<table cellspacing='0' cellpadding='4'>
		<tr>
			<td>
				<?php echo $record['UserAddress']['first_name']; ?>, <br />
				Your order has shipped and is on its way. <br />
				Below is your tracking number: 
				<br /><br />
				<?php 
				
					switch(strtoupper($record['CanteenShippingRecord']['carrier_name'])) {
						
						case "USPS":
							echo "*NOTE: It may take up to 24 hrs for your shipment to start tracking on the USPS website. <br /><br />";
							if(!empty($record['CanteenShippingRecord']['tracking_number'])) {

								echo "<a href='http://trkcnfrm1.smi.usps.com/PTSInternetWeb/InterLabelInquiry.do?origTrackNum={$record['CanteenShippingRecord']['tracking_number']}'>USPS: {$record['CanteenShippingRecord']['tracking_number']}</a>";
								
							} else {
								
								echo "*NOTE: International Shipments Will Stop Tracking Once They Leave The United States";
								echo "<br />";
								echo "<a href='http://trkcnfrm1.smi.usps.com/PTSInternetWeb/InterLabelInquiry.do?origTrackNum={$record['CanteenShippingRecord']['shipment_number']}'>USPS International: {$record['CanteenShippingRecord']['shipment_number']}</a>";
								
							}
						break;
						
					}
				
				?>	
				<br />
				<br />
				You can always view the status of your order on TheBerrics.com by using the following link: <br /><br />
				http://theberrics.com/canteen/order/<?php echo $record['CanteenOrder']['hash']; ?>
			</td>
		</tr>
	</table>
</div>