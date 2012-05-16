<?php 

$data = unserialize($msg['EmailMessage']['serialized_data']);

$co = ClassRegistry::init("CanteenOrder");

//get the order

$order = $co->find("first",array(
	"conditions"=>array(
		"CanteenOrder.id"=>$msg['EmailMessage']['foreign_key']
	),
	"contain"=>array()
));

if(!empty($data['orig_id'])) {
	
	$orig_note = $co->CanteenOrderNote->find("first",array(
		"conditions"=>array(
			"CanteenOrderNote.id"=>$data['orig_id']
		),
		"contain"=>array()
	));
	
}

if(!empty($data['reply_id'])) {
	
	$reply_note = $co->CanteenOrderNote->find("first",array(
		"conditions"=>array(
			"CanteenOrderNote.id"=>$data['orig_id']
		),
		"contain"=>array("User")
	));
	
}

?>
<table cellspacing='0' cellpadding='5' border='0'>
	<tr>
		<td>
			A new note has been added to your order. <br />
			Below is your original correspondence including our reply. <br />
			Use the following link to view your order on theberrics.com <br />
			<strong>Order Status:</strong> <a href='http://theberrics.com/canteen/order/<?php echo $order['CanteenOrder']['hash']; ?>'>http://theberrics.com/canteen/order/<?php echo $order['CanteenOrder']['hash']; ?></a>
			
		</td>
	</tr>
	<?php if(isset($orig_note)): ?>
	<tr>
		<td>
			<div><strong>You</strong></div>
			<?php echo $orig_note['CanteenOrderNote']['message']; ?>
		</td>
	</tr>
	<?php endif; ?>
	<?php if(isset($reply_note)): ?>
	<tr>
		<td>
			<div><strong>The Berrics</strong></div>
			<?php echo $reply_note['CanteenOrderNote']['message']; ?>
		</td>
	</tr>
	<?php endif; ?>
</table>
