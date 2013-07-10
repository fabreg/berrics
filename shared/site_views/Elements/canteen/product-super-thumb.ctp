<?php 

$price = Set::extract("/CanteenProductPrice[currency_id={$user_currency_id}]",$product);

?>
<div class='canteen-product-thumb'>
	<div class='info'>
		<?php if(count($product['RelatedStyles'])): ?>
			<div class='style-label'><?php echo strtoupper($product['CanteenProduct']['style_code_label']); ?></div>
			<?php if(!empty($product['CanteenProduct']['style_code_image'])): ?>
				<div class='style-code-image'>
					<a href='/canteen/item/<?php echo $product['CanteenProduct']['uri']; ?>'>
						<img border='0' src='http://img01theberrics.com/i.php?src=/product-img/<?php echo $product['CanteenProduct']['style_code_image']; ?>&w=40&h=40&zc=1'/>
					</a>
				</div>
			<?php endif; ?>
			<?php foreach($product['RelatedStyles'] as $r): ?>
				<div class='style-code-image'>
					<a href='/canteen/item/<?php echo $r['CanteenProduct']['uri']; ?>'>
						<img border='0' src='http://img01theberrics.com/i.php?src=/product-img/<?php echo $r['CanteenProduct']['style_code_image']; ?>&w=40&h=40&zc=1'/>
					</a>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
	<div class='thumb-inner'>
		<a href='/canteen/item/<?php echo $product['CanteenProduct']['uri']; ?>' title="<?php echo addslashes($product['CanteenProduct']['name']); ?> By: <?php echo addslashes($product['Brand']['name']); ?>">
		<?php 
			echo $this->Media->productListThumb($product,array("w"=>"240","lazy"=>false));	
		?>
		</a>
	</div>
	<div class='brand'>
		<?php echo strtoupper($product['Brand']['name']); ?>
	</div>
	<div class='name'><?php echo strtoupper($product['CanteenProduct']['name']); ?></div>
	<div class='sub-title'><?php echo $product['CanteenProduct']['sub_title']; ?>&nbsp;</div>
	<div class='price'>
		<?php echo $this->Berrics->currency($price[0]['CanteenProductPrice']['price'],$user_currency_id); ?>
	</div>
</div>