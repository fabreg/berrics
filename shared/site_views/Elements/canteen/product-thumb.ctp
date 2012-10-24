<?php 

$price = Set::extract("/CanteenProductPrice[currency_id={$user_currency_id}]",$product);

?>
<div class='canteen-product-thumb'>
	<div class='info'>
		<div class='info-spacer'></div>
		<div class='brand'>
			<?php echo strtoupper($product['Brand']['name']); ?>
		</div>
		<div class='name'><?php echo strtoupper($product['CanteenProduct']['name']); ?></div>
		<div class='sub-title'><?php echo $product['CanteenProduct']['sub_title']; ?>&nbsp;</div>
		<div class='price'>
			<?php echo $this->Berrics->currency($price[0]['CanteenProductPrice']['price'],$user_currency_id); ?>
		</div>
	</div>
	<div>
		<a href='/canteen/item/<?php echo $product['CanteenProduct']['uri']; ?>' title="<?php echo addslashes($product['CanteenProduct']['name']); ?> By: <?php echo addslashes($product['Brand']['name']); ?>">
		<?php 
			echo $this->Media->productListThumb($product,array("w"=>"240","lazy"=>true));	
		?>
		</a>
	</div>

</div>