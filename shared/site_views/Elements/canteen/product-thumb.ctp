<?php 

$price = Set::extract("/CanteenProductPrice[currency_id={$user_currency_id}]",$product);

?>
<div class='product-thumb'>
	<div class='img'>
		<a href='/canteen/item/<?php echo $product['CanteenProduct']['uri']; ?>' title="<?php echo addslashes($product['CanteenProduct']['name']); ?> By: <?php echo addslashes($product['Brand']['name']); ?>">
		<?php 
			echo $this->Media->productListThumb($product,array("w"=>"300","lazy"=>true));	
		?>
		</a>
	</div>
	<div class='info'>
		
		<div class='price'>
			<?php echo $this->Berrics->currency($price[0]['CanteenProductPrice']['price'],$user_currency_id); ?>
		</div>
		<div class='name'><?php echo strtoupper($product['CanteenProduct']['name']); ?> <span class='sub-title'><?php echo $product['CanteenProduct']['sub_title']; ?>&nbsp;</span></div>
		
		<div class='brand'>
			BY: <?php echo strtoupper($product['Brand']['name']); ?>
		</div>
		
	</div>
</div>