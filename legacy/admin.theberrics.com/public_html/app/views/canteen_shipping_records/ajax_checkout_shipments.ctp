<?php if(isset($record['CanteenShippingRecord']['id'])): ?>
<div>
Shipment ID (<?php echo $record['CanteenShippingRecord']['id']; ?>) Status Updated To <span style='color:green; font-weight:bold;'>"SHIPPED"</span>
<?php if($send_email): ?>
 | Email Sent
<?php endif; ?>

<?php if($process_inventory): ?>
 | Inventory Processed
<?php endif; ?>
</div>
<?php else: ?>
<div class='record-error'>
	There was an error while looking up this record: <?php echo $this->data['CanteenShippingRecord']['ref_number']; ?>
</div>
<?php endif;?>