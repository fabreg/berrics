<?php 
	
	$order_table = $this->element("account/order-history-table");
	pr($order_table);
	echo $this->element("paper1",array("content"=>$order_table));

?>