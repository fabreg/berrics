<?php 

//pr($product['RelatedStyles']);


?>
<style>

#left-col {

	width:100%;
	float:none;

}

#product-standard-view .left {

	width:430px;
	float:left;
}

#product-standard-view .right {

	width:600px;
	float:right;
	
}

#product-info h1 {

	font-size:28px;

}
#options-select-div {

	text-align:right;


}

#qty-div {

	

}

#add-to-cart-div {


}

.canteen-product-option-div {

	width:80px;
	float:left;
	border:1px solid #ccc;
	padding:3px;
	text-align:center;
	margin-right:3px;

}
.product-options {

	clear:both;

}

</style>
<div id='product-standard-view'>
	<div class='right'>
		<div id='product-info'>
			<h1><?php echo $product['Brand']['name']; ?> | <?php echo $product['CanteenProduct']['name']; ?></h1>
			<?php 
			
				echo $this->element("canteen_product/pricing-options");
			
			?>
			<div style='clear:both;'></div>
			<?php 
				echo nl2br($product['CanteenProduct']['description']);
			?>
		</div>
	</div>
	<div class='left'>
		<div id='product-img'>
			<?php 
				foreach($product['CanteenProductImage'] as $k=>$img):
			?>
				<?php 
					if($k==0):
				?>
				<?php echo $this->Media->productThumb($img,array("w"=>400)); ?>
				<?php else: ?>
				
				<?php 
					endif;
				?>
			<?php 
				endforeach;
			?>
		</div>
		<?php 
			echo $this->element("canteen_product/related-styles");
		?>
	</div>
	<!--  Product Image -->


</div>