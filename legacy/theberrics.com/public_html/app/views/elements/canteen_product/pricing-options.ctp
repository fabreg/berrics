<script type='text/javascript'>
$(document).ready(function() { 


	$('input[name="data[CanteenOrderItem][canteen_product_id]"]:eq(0)').attr("disabled",false);




	
});

function selectOption(id) {


	
}
</script>
<?php 
$o = $product['CanteenProductOption'];

$uri = "/canteen/cart/add";

if($this->Session->check("CanteenAdminAddItem.canteen_order_item")) {
	
	$uri = "http://dev.admin.theberrics.com/canteen_orders/add_item";
	
}

echo $this->Form->create("CanteenOrder",array("url"=>$uri));
?>
<div class='price'>
				<?php 
					echo $price['Currency']['symbol']." ".$price['price']; 
				?>
</div>
				
				<?php 
				
					if(count($o)>0) {
						
						$options = array();
						echo "<div class='product-options'>";
						foreach($o as $opt) {
							
							//$options[$opt['id']] = $opt['opt_label']." : ".$opt['opt_value'];
							echo $this->element("canteen_product/product-option-div",compact("opt"));
							
						}
						echo "</div><div style='clear:both;'></div>";
						
						//echo $this->Form->input("CanteenOrderItem.canteen_product_option_id",array("options"=>$options,"div"=>array("id"=>"options-select-div")));
						
					} else {
						
						echo $this->Form->input("CanteenOrderItem.canteen_product_id",array("value"=>$product['id'],"type"=>"hidden"));
						
					}
					
					
					echo $this->Form->input("CanteenOrderItem.quantity",array("value"=>1,"div"=>array("id"=>"qty-div")));
					echo $this->Form->input("CanteenOrderItem.parent_canteen_product_id",array("value"=>$product['CanteenProduct']['id'],"type"=>"hidden"));
					echo $this->Form->input("CanteenOrderItem.currency_id",array("value"=>$user_currency,"type"=>"hidden"));
					echo $this->Form->submit("Add To Cart",array("div"=>array("id"=>"add-to-cart-div")));
				
				?>
<?php  
	echo $this->Form->end();
?>