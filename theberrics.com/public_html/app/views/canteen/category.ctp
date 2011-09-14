<style>
#top-banner-container {
	
	display:none;

}
</style>
<?php 
foreach($products as $p):
?>
<?php echo $this->element("canteen/product-thumb",array("product"=>$p)); ?>
<?php 
endforeach;
?>
<?php

print_r($category);
pr($products);
?>
