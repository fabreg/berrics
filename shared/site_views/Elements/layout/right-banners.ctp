<?php 
echo $this->element("banner-placements/default-layout-300x250-top");
echo $this->element("layout/right-col-social-buttons");
echo $this->element("banner-placements/default-layout-300x250-bottom");
?>
<div style='height:15px;'></div>
<?php 
echo $this->element("featured-post");
?>
<div style='height:15px;'></div>
<div id='featured-canteen-product'>
	<div class='inner'>
		<?php echo $this->element("canteen/product-thumb",array("product"=>$home_random_product)); ?>
	</div>
</div>