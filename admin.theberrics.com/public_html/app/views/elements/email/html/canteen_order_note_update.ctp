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

?>
<style>
p {

	padding:5px;
	margin:5px;

}
</style>
<div style='padding:10px;'>
	<p>
	A new note has been added to your order. Use the following link to view your order on theberrics.com <br />
		<strong>Order Status:</strong> <a href='http://theberrics.com/canteen/order/<?php echo $order['CanteenOrder']['hash']; ?>'>http://theberrics.com/canteen/order/<?php echo $order['CanteenOrder']['hash']; ?></a>
	
	</p>
	<p>
	</p>
</div>