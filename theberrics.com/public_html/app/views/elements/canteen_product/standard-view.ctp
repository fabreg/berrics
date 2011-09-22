<?php 

//pr($product['RelatedStyles']);


?>
<style>
#product-standard-view {

	height:559px;
	background-image:url(/img/layout/canteen/standard-view/prod-bg.jpg);
	


}
#product-standard-view .product-info {

	float:right;
	width:492px;

}

#product-standard-view .product-info h1 {

	font-size:24px;
	color:#000;
	height:70px;
	line-height:70px;
}

#product-standard-view .product-info .style-code {

	color:#663333;
	font-style:italic;
	text-align:right;
	padding-right:10px;
	padding-top:19px;
	font-size:15px;
	font-weight:bold;
	
}

#product-standard-view .product-img {


}

#product-standard-view .product-info .name {

	margin-top:10px;
	
	position:relative;
	height:70px;
}

#product-standard-view .product-info .name .price {

	position:absolute;
	right:10px;
	top:0px;
	width:95px;
}
#product-standard-view .product-info .description {

	font-family:'courier';
	font-size:13px;
	padding-right:20px;
	color:#000;
	text-align:justify;
}
</style>
<div id='product-standard-view'>
		
		<div class='product-info'>
			<div class='style-code'>
				Item#: <?php echo $product['CanteenProduct']['style_code']; ?>
			</div>
			<div class='name'>
				<h1><?php echo $product['CanteenProduct']['name']; ?></h1>
				<div class='price'>
					<div class='label'>Price</div>
						<?php 

							echo $price['Currency']['symbol']." ".$price['price']; 
				
						?>
				</div>
				<div style=clear:both;'></div>
			</div>
			<div class='description'>
				<?php 
					echo nl2br($product['CanteenProduct']['description']);
				?>
			</div>
			<?php if(isset($product['RelatedStyles']) && count($product['RelatedStyles'])>0): ?>
			<div class='aux-options'>
				<div class='label'></div>
				<?php foreach($product['RelatedStyles'] as $s): ?>
				<div class='aux-option'>
					
				</div>
				<?php endforeach; ?>
			</div>
			<?php endif; ?>
			<?php 
			
				echo $this->element("canteen_product/pricing-options");
			
			?>
			<div style='clear:both;'></div>
				
		</div>
		
	
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
	
	<!--  Product Image -->


</div>
<?php 
pr($product);
?>