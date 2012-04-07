<?php 

$order['CanteenOrder']['sub_total'] = $this->Number->currency($order['CanteenOrder']['sub_total'],$order['CanteenOrder']['currency_id']);

$order['CanteenOrder']['tax_total'] = $this->Number->currency($order['CanteenOrder']['tax_total'],$order['CanteenOrder']['currency_id']);

$order['CanteenOrder']['grand_total'] = $this->Number->currency($order['CanteenOrder']['grand_total'],$order['CanteenOrder']['currency_id']);

die(json_encode($order));

?>