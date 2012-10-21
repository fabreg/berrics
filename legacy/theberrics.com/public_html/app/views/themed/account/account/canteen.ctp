<?php 
	
	$order_table = $this->element("account/order-history-table");
	
	echo $this->element("paper1",array("content"=>$order_table));

?>