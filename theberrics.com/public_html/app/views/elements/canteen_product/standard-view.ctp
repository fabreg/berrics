<?php 

//pr($product['RelatedStyles']);


?>
<style>
#product-standard-view {

	height:559px;
	background-image:url(/img/layout/canteen/standard-view/prod-bg.jpg);
	


}

#product-standard-view label {

	font-family:'Arial';
	font-size:11px;
	font-weight:bold;
	color:#333;

}

#product-standard-view .product-info {

	float:right;
	width:492px;

}

#product-standard-view .product-info .name {


}

#product-standard-view .product-info h1 {

	font-size:24px;
	color:#000;
	
	line-height:24px;
	
}

#product-standard-view .product-info h2 {

	font-size:18px;
	font-style:italic;
	color:#333;
	margin:0px;
	padding:0px;
	text-indent:5px;
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
	float:left;
	position:relative;
	height:70px;
}

#product-standard-view .product-info .pricing {

	float:right;
	margin-right:37px;
	
}

#product-standard-view .product-info .pricing .price {
	width:130px;
	border:1px solid #999;
	padding:7px;
	font-size:24px;
	font-family:'Courier';
	color:#333;
}




#product-standard-view .product-info .description {
	
	width:435px;
	
	font-family:'courier';
	font-size:13px;
	padding:10px;
	color:#000;
	text-align:justify;
	border:1px solid #999;
	
	
}

#product-standard-view .style-code-options .options-div {

	border:1px solid #999;
	width:455px;
	
}

#product-standard-view .style-code-options .options-div .option {

	border-right:1px solid #999;
	width:50px;
	text-align:center;
	float:left;
	padding-left:4px;
	padding-right:4px;
	cursor:pointer;
}

#product-standard-view .style-code-options .options-div .option .check {

	background-image:url(/img/layout/canteen/standard-view/unchecked.png);
	background-repeat:no-repeat;
	background-position:center center;
	height:17px;
	clear:both;
	margin:auto;
	margin-top:2px;
	margin-bottom:2px;
}

#product-standard-view .style-code-options .options-div .option .checked {

	background-image:url(/img/layout/canteen/standard-view/checked.png);

}

#product-standard-view .product-options {

	width:455px;

}

#product-standard-view .product-options .options-div {

	border:1px solid #999;
	

}

#product-standard-view .product-options .options-div .option {

	float:left;
	border-right:1px solid #999;
	font-family:'Courier';
	font-size:26px;
	color:#333;
	text-align:center;
	padding-left:3px;
	padding-right:3px;
	cursor:pointer;
}

#product-standard-view .product-options .options-div .option .check {

	background-image:url(/img/layout/canteen/standard-view/unchecked.png);
	background-repeat:no-repeat;
	background-position:center center;
	height:17px;
	clear:both;
	margin:auto;
	margin-top:2px;
	margin-bottom:2px;
	width:45px;

}
#product-standard-view .product-options .options-div .option .checked {

	background-image:url(/img/layout/canteen/standard-view/checked.png);

}

#product-standard-view .submit input {

	padding:0px;
	text-indent:-1000000px;
	margin:0px;
	background-color:transparent;
	border:none;
	background-image:url(/img/layout/canteen/standard-view/add-to-cart.jpg);
	height:28px;
	width:213px;
	cursor:pointer;
}

#product-standard-view .submit-button {


	float:left;
	margin-top:20px;

}
#product-standard-view .zuckerberg-shoutout {

	float:right;
	margin-top:24px;

}
#product-standard-view .zuckerberg-shoutout span {
	
	float:left;

}
</style>
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
<div id='product-standard-view'>
		
		<div class='product-info'>
			<?php 
					$o = $product['CanteenProductOption'];

$uri = "/canteen/cart/add";

if($this->Session->check("CanteenAdminAddItem.canteen_order_item")) {
	
	$uri = "http://dev.admin.theberrics.com/canteen_orders/add_item";
	
}
					echo $this->Form->create("CanteenOrder",array("url"=>$uri));
			?>
			<div class='style-code'>
				Item#: <?php echo $product['CanteenProduct']['style_code']; ?>
			</div>
			<div class='name'>
				<h1><?php echo $product['CanteenProduct']['name']; ?></h1>
				<h2><?php echo $product['CanteenProduct']['sub_title']?>&nbsp;</h2>
			</div>
			<div class='pricing'>
					<label>PRICE: (<?php echo strtoupper($user_currency_id); ?>)</label>
					<div class='price'>
						<?php 
 
							echo $price['Currency']['symbol']." ".$price['price']; 
				
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
						<img src='http://img.theberrics.com/i.php?src=/product-img/<?php echo $s['CanteenProduct']['style_code_image']; ?>&w=35' border='0' alt='' />
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