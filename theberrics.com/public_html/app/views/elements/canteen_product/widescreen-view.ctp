
<style>

#right-col {
	
	display:none;

}

#left-col {

	width:100%;

}

#product-view {

	background-color:black;
	width:980px;
	margin:auto;
	padding-top:30px;
}

#product-view .inner {

	width:950px;
	margin:auto;

}

#product-view .large-img {
	
	text-align:center;
	

}

#product-view .product-name h1 {
	
	margin:0px;
	padding:3px;
	font-size:26px;
	color:#333;

}

#product-view .product-info {
	
	

}
#product-view .product-info .left {

	float:left;
	width:49%;

}


#product-view .product-info .right {

	float:right;
	width:49%;

}

#product-view .product-info .price {

	

}

</style>
<div id='product-view'>
	<div class='inner'>
		<div class='product-name'>
			<h1><?php echo $p['name']; ?> By <?php echo $b['name']; ?></h1>
		</div>
		<div class='large-img'>
			<?php 
				
				echo $this->Media->productThumb($i[0],array("w"=>950));
			
			?>
		</div>
		<hr />
		<div class='product-info'>
			<?php 
				echo $this->Form->create("CanteenCart",array("url"=>"/canteen/cart/add"));
			?>
			<div class='left'>
				
			</div>
			<div class='right'>
				<div class='price'>
				<?php 
					echo $price['Currency']['symbol']." ".$price['price']; 
				?>
				</div>
				
				<?php 
				
					if(count($o)>0) {
						
						$options = array();
						
						foreach($o as $opt) {
							
							$options[$opt['id']] = $opt['opt_label']." : ".$opt['opt_value'];
							
						}
						
						echo $this->Form->input("CanteenProductOption.id",array("options"=>$options));
						
					} else {
						
						echo $this->Form->input("CanteenProductOption.id",array("value"=>$p['id']));
						
					}
					
					
					echo $this->Form->input("CanteenProductOption.quantity",array("value"=>1));
					echo $this->Form->input("currency_id",array("value"=>$user_currency,"type"=>"hidden"));
					echo $this->Form->submit("Add To Cart");
				
				?>
				
			</div>
			<div style='clear:both;'></div>
			<?php  
				echo $this->Form->end();
			?>
		</div>
	</div>
</div>