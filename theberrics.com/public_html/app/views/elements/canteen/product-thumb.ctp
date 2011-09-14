<div class='canteen-product-thumb'>
	<div class='info'>
		<div class='info-spacer'></div>
		<div class='brand'>
			<?php echo strtoupper($product['Brand']['name']); ?>
		</div>
		<div class='name'><?php echo strtoupper($product['CanteenProduct']['name']); ?></div>
		<div class='sub_title'></div>
	</div>
	<div>
		<?php 
		
			echo $this->Media->productListThumb($product,array("w"=>"262"));
		
		?>
	</div>
	<div>
	
	</div>
</div>