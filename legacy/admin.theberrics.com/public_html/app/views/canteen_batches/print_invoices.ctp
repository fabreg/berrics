<?php 

foreach($orders as $o) echo $this->element("canteen_orders/printable_invoice",array("order"=>$o));

?>