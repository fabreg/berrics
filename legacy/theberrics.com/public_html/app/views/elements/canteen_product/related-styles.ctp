<?php 
if(count($product['RelatedStyles'])>0):
?>
	<?php 
		foreach($product['RelatedStyles'] as $v):
	?>
		<div class='related-style-thumb'>
			<?php 
				echo $this->Media->productThumb($v['CanteenProductImage'][0],array("w"=>75));
			?>
		</div>
	<?php 
		endforeach;
	?>
<?php 
endif;
?>