<?php 

$this->set("right_column","");

$p = $product['CanteenProduct'];
$i = $product['CanteenProductImage'];
$b = $product['Brand'];
$o = $product['CanteenProductOption'];

$user_currency = CanteenConfig::returnUserCurrencyId($_SERVER['GEOIP_COUNTRY_CODE']);


$price = Set::extract("/CanteenProductPrice[currency_id={$user_currency_id}]",$product);

$price = $price[0]['CanteenProductPrice'];

$merch_template = $p['merch_template'];

$this->set(compact("price","user_currency"));

echo $this->element("canteen_product/{$merch_template}-view");

?>