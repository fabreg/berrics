<?php 

$this->set("title_for_layout",$product['CanteenProduct']['name']." By:".$product['Brand']['name']);
$this->set("meta_d",$product['CanteenProduct']['description']);
?>
<script>
$(document).ready(function() { 



	$('.options-div .option .check:eq(0)').addClass('checked');


	initStyleClick();
	initOptionClick();

	$("#product-standard-view .product-options .option:eq(0)").click();
	
});


function initStyleClick() {


	$("#product-standard-view .style-code-options .option").click(function() { 

		var uri = $(this).attr("uri");

		return document.location.href = uri;
				
	});
	
	
}

function initOptionClick() {


	$("#product-standard-view .product-options .option").click(function() { 


		var id = $(this).attr("canteen_product_option_id");

		//pop the field

		$("#CanteenOrderItemCanteenProductOptionId").val(id);


		//uncheckk allllllll of them

		$("#product-standard-view .product-options .option .check").removeClass("checked");

		//now check me!
		$(this).find(".check").addClass("checked");
		
	});

	
}



</script>
<div style='height:30px;'>
<?php if($this->Session->check("is_admin")): ?>
<a href='http://dev.admin.theberrics.com/canteen_products/edit/<?php echo $product['CanteenProduct']['id']; ?>' target='_blank'>Edit</a>
<?php endif; ?>
</div>
<div id='product-standard-view'>
		<div class='container'>
			<div class='container-top'>
				<div class='wrapper'>
					<div class='product-info'>
						<?php 
								$o = $product['CanteenProductOption'];
				
								$uri = "/canteen/cart/add";
								
								if($this->Session->check("CanteenAdminAddItem.canteen_order_item")) {
									
									$uri = "http://dev.admin.theberrics.com/canteen_orders/add_item";
									
								}
								echo $this->Form->create("CanteenOrder",array("url"=>$uri));
						?>
						<div class='codes'>
							<div class='brand'>
								<?php echo strtoupper($product['Brand']['name']); ?>
							</div>
							<div class='style-code'>
								ITEM#: <?php echo $product['CanteenProduct']['style_code']; ?>
							</div>
							<div style='clear:both;'></div>
						</div>
						
						<div class='name'>
							<h1><?php echo $product['CanteenProduct']['name']; ?></h1>
							<h2><?php echo $product['CanteenProduct']['sub_title']?>&nbsp;</h2>
						</div>
						<div class='pricing'>
								<label>PRICE: (<?php echo strtoupper($user_currency_id); ?>)</label>
								<div class='price'>
									<?php 
			 
										//echo $price['Currency']['symbol']." ".$price['price']; 
										echo $this->Number->currency($price['price'],$user_currency_id);	
										//echo $this->Store->formatMoney($price['price'],$user_currency_id);
									?>
								</div>
						</div>
						<div style=clear:both;'></div>
						<?php if(!empty($product['CanteenProduct']['description'])): ?>
						<label>DESCRIPTION:</label>
						<div class='description'>
							
							<?php 
								echo nl2br($product['CanteenProduct']['description']);
							?>
						</div>
						<?php endif; ?>
						<?php if(isset($product['RelatedStyles']) && count($product['RelatedStyles'])>0): 
									array_push($product['RelatedStyles'],array("CanteenProduct"=>$product['CanteenProduct']));
									$product['RelatedStyles'] = array_reverse($product['RelatedStyles']);
						?>
						<div class='style-code-options'>
							<label><?php echo strtoupper($product['CanteenProduct']['style_code_label']); ?>:</label>
							<div class='options-div'>
								
								<?php foreach($product['RelatedStyles'] as $s): ?>
								<div class='option' uri='<?php echo $s['CanteenProduct']['uri']; ?>'>
									<div class='check'>
										
									</div>
									<img src='http://img.theberrics.com/i.php?src=/product-img/<?php echo $s['CanteenProduct']['style_code_image']; ?>&h=35' border='0' alt='' />
								</div>
								<?php endforeach; ?>
								<div style='clear:both;'></div>
							</div>
						</div>
						<?php endif; ?>
						<?php if(isset($product['CanteenProductOption']) && count($product['CanteenProductOption'])>0): ?>
						<div class='product-options'>
							<label>CHOOSE AN OPTION:</label>
							<div class='options-div'>
								<?php foreach($product['CanteenProductOption'] as $o): ?>
								<div class='option' canteen_product_option_id='<?php echo $o['id']; ?>'>
									<div class='check'></div>
									<?php echo $o['opt_value']; ?>
								</div>
								<?php endforeach; ?>
								<div style='clear:both;'></div>
							</div>
							<div style='clear:both;'></div>
						</div>
						<?php else: ?>
						
						<?php endif; ?>
						
						<?php if(count($product['Meta'])>0): ?>
						<div class='product-specs'>
							<label>SPECIFICATIONS:</label>
							<div class='meta-div'>
								<?php foreach($product['Meta'] as $m): ?>
								<dl>
									<dt><?php echo strtoupper($m['key']); ?>:</dt>
									<dd><?php echo strtoupper($m['val']); ?></dd>
								</dl>
								<?php endforeach; ?>
								<div style='clear:both;'></div>
							</div>
						</div>
						<?php endif; ?>
						<div id='h-fields' style='display:none;'>
							<?php
								echo $this->Form->input("CanteenOrderItem.quantity",array("type"=>"hidden","value"=>"1"));
								echo $this->Form->input("CanteenOrderItem.canteen_product_id",array("type"=>"hidden","value"=>$product['CanteenProduct']['id']));
								echo $this->Form->input("CanteenOrderItem.canteen_product_option_id",array("type"=>"hidden"));
							?>
						</div>
						<div class='submit-button'>
							<?php echo $this->Form->submit("Add to Cart"); ?>
						</div>
						<div class='zuckerberg-shoutout'>
							<div style='float:left; margin-right:4px;'>
								<a href="http://twitter.com/share" class="twitter-share-button" data-url="<?php echo "http://".$_SERVER['SERVER_NAME'].$url; ?>" data-text='<?php echo addslashes($d['name']." ".$d['sub_title']); ?>' data-count="none" data-via="berrics">Tweet</a>
							</div> 
							<fb:like href="<?php echo urlencode("http://".$_SERVER['SERVER_NAME']."/canteen/item/".$product['CanteenProduct']['uri']); ?>" layout="button_count" show_faces="false" width="25" font="lucida grande"></fb:like>
						</div>
						<div style='clear:both;'></div>
						<?php echo $this->Form->end(); ?>
					</div>
					
				
					<div class='product-img'>
						<div class='main-image'>
								
							<?php 
								
								$img = Set::extract('/CanteenProductImage[front_image=1]',$product);
								
								if(count($img)<0) {
									
									$img = $product['CanteenProductImage'][0];
									
								} else {
									
									$img = $img[0]['CanteenProductImage'];
									
								}
								
								echo $this->Media->productThumb($img,array("w"=>485)); 
								
							?>
						
						</div>
						<div class='thumbs'>
							<?php foreach($product['CanteenProductImage'] as $img): ?>
								<div class='img-thumb'>
									<?php echo $this->Media->productThumb($img,array("w"=>50)); ?>
								</div>
							<?php endforeach;?>
						</div>
					</div>
					<div style='clear:both;'></div>
				</div>
			</div>
			
		</div>
		<div class='container-bottom'></div>
</div>
<?php 
pr($product);
?>