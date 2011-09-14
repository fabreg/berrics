<style>
.canteen-product-thumb {

	float:left;
	margin-left:5px;

}

</style>
<script type='text/javascript'>
$(document).ready(function() { 


	$('.canteen-product-thumb').hover(
		function() { 

			$(this).find('.info').fadeIn();
			
		},
		function() { 

			$(this).find('.info').hide();
			
		}
	);


	
});
</script>
<div id='canteen-category'>
<?php 
foreach($products as $p):
?>
<?php echo $this->element("canteen/product-thumb",array("product"=>$p)); ?>
<?php 
endforeach;
?>
	<div style='clear:both;'></div>
</div>

<?php

print_r($category);
pr($products);
?>
