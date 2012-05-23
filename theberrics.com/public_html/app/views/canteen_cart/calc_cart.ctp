<?php 

$order['CanteenOrder']['sub_total'] = $this->Berrics->currency($order['CanteenOrder']['sub_total'],$order['CanteenOrder']['currency_id']);

$order['CanteenOrder']['tax_total'] = $this->Berrics->currency($order['CanteenOrder']['tax_total'],$order['CanteenOrder']['currency_id']);

$order['CanteenOrder']['grand_total'] = $this->Berrics->currency($order['CanteenOrder']['grand_total'],$order['CanteenOrder']['currency_id']);

$order['CanteenOrder']['shipping_total'] = $this->Berrics->currency($order['CanteenOrder']['shipping_total'],$order['CanteenOrder']['currency_id']);

die(json_encode($order));

?>