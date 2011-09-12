<style>
#left-col {
	width:100%;
}

#canteen-cart .cart-items {
	width:99%;
	margin:auto;
}

#canteen-cart .cart-table {
	border:1px solid #999;
	border-top:none;
	border-left:none;
	width:100%;
}

#canteen-cart .cart-table th {

	padding:4px;
	border:1px solid #999;
	border-bottom:none;
	border-right:none;

}

#canteen-cart .cart-table td {

	padding:4px;
	border:1px solid #999;
	border-bottom:none;
	border-right:none;
}

.totals-list {

	margin:10px;
	padding:5px;
	width:240px;
}

.totals-list dt {

	width:100px;
	height:35px;
	line-height:35px;
	text-align:right;
}
.totals-list dd {

	margin-left:105px;
	height:35px;
	padding-right:4px;
	line-height:35px;
	margin-top:-35px;
	text-align:right;
}

#checkout-form {


}

#checkout-form .right {

	width:250px;
	float:right;
	border:1px solid red;

}

#checkout-form .left {

	width:760px;
	float:left;
	height:417px;
	background-image:url(/img/layout/canteen/checkout-form-bg.png);
	background-repeat:no-repeat;
}

#checkout-form .left .customer-info {
	
	float:left;
	width:49%;

}

#checkout-form .left .payment-info {

	float:right;
	width:49%;

}

/*FORM STUFF*/
#checkout-form label {

	width:35%;
	text-align:right;
	padding-right:3px;
	float:left;
	font-size:16px;
	color:#666;
}

#checkout-form div.text,#checkout-form div.select {
	

	line-height:30px;

}

#checkout-form div.text input,#checkout-form div.select select {

	width:60%;
	font-size:14px;
	background-color:#fff;
	border:1px solid #666;
	color:#333;
	height:25px;
	line-height:25px;
	padding:0px;
	margin:0px;
	text-indent:3px;
}

#checkout-form div.error input,#checkout-form div.error select {

	background-color:red;
	color:white;
	border:1px solid #fff;

}

#checkout-form .error-message {

	display:none;

}

#checkout-form .submit {

	text-align:center;
	

}

#checkout-form .checkout-header {

	text-align:center;
	padding:5px;
	font-size:28px;
	color:#666;
	padding-top:10px;
}

#billing-form {

	display:none;

}

#same-as-shipping-check {

	float:left;

}

#same-as-shipping-div label {

	width:80%;
	text-align:left;
}

</style>
<script>

<?php 
if(isset($errors)):
?>
var _form_errors = <?php echo json_encode($errors); ?>;
<?php 
endif;
?>


var _geo_country = '<?php echo $_SERVER['GEOIP_COUNTRY_CODE']; ?>';

$(document).ready(function() { 


	$("#CanteenOrderCountry").find("option[value="+_geo_country+"]").attr("selected",true);

	$("#checkout-form div.error input, #checkout-form div.error select").focus(function() { 

		$(this).parent().removeClass("error");

	});

	//the billing form
	$("#same-as-shipping-check").click(function() { 

		toggleBilling($("#same-as-shipping-check"));

	});
	toggleBilling($("#same-as-shipping-check"));
	
	
	
	
});

function toggleBilling(check) {


	if($(check).is(':checked')) {

		$("#billing-form").slideUp();
		
	} else {

		$("#billing-form").slideDown();

	}
	

	
}

</script>
<?php echo $this->Form->create("CanteenOrder",array("url"=>$this->here)); ?>
<div id='canteen-cart'>
	<div class='canteen-div-1'>
		<div class='top'>
			<div class='right'></div>
			<div class='left'></div>
			<div style='clear:both;'></div>
		</div>
		<div>
		
		</div>
		<div>
		
		</div>
		<div class='bottom'>
			<div class='right'></div>
			<div class='left'></div>
			<div style='clear:both;'></div>
		</div>
	</div>
	<div id='cart-items'>
		<h1><?php echo Lang::instance()->p("CommonFields","shoppingcart",$user_locale); ?> <span><a href='/canteen/'><?php echo Lang::instance()->p("CommonFields","continueshopping",$user_locale); ?></a></span></h1>
		<table cellspacing='0' class='cart-table'>
			<tr>
				<th>-</th>
				<th><?php echo Lang::instance()->p("CommonFields","items",$user_locale); ?></th>
				<th><?php echo Lang::instance()->p("CommonFields","qty",$user_locale); ?></th>
				<th><?php echo Lang::instance()->p("CommonFields","price",$user_locale); ?></th>
			</tr>
			<?php 
				foreach($this->data['CanteenOrderItem'] as $k=>$item):
			?>
			<tr>
				<td width='1%'>
				<?php 
				
					$img = Set::extract("/CanteenProductImage[thumb_image=1]",$item);
					
					if(count($img)<=0) {
						
						$img = Set::extract("/CanteenProductImage[front_image=1]",$item);
						
					}
					
					echo $this->Media->productThumb($img[0]['CanteenProductImage'],array("h"=>75,"w"=>75));
					
					echo $this->Form->input("CanteenOrderItem.{$k}.canteen_product_id",array("type"=>"hidden","value"=>$item['CanteenProduct']['id']));
					echo $this->Form->input("CanteenOrderItem.{$k}.canteen_product_option_id",array("type"=>"hidden","value"=>$item['CanteenProductOption'][0]['id']));
					echo $this->Form->input("CanteenOrderItem.{$k}.quantity",array("type"=>"hidden","value"=>$item['CanteenOrderItem'][0]['quantity']));
					
				?>
				</td>
				<td>
					<?php echo $item['CanteenProduct']['name']; ?> 
					
					<?php if(!empty($item['CanteenProductOption'][0]['opt_label'])): ?>
					<br /><?php echo $item['CanteenProductOption'][0]['opt_label']; ?> : <?php echo $item['CanteenProductOption'][0]['opt_value']; ?>
					<?php endif; ?>
				</td>
				<td align='center'><?php echo $item['quantity']; ?></td>
				<td align='center'><?php echo $this->Number->currency($item['CanteenProductPrice'][0]['price'],$item['CanteenProductPrice'][0]['Currency']['id']); ?></td>
			</tr>
			<?php 
				endforeach;
			?>
		</table>
	</div>
	<hr />
	<div id='checkout-form'>
		<div class='right' > 
			<dl class='totals-list'>
				<dt>Sub-Total</dt>
				<dd><?php echo $this->Number->currency($this->data['CanteenOrder']['total'],$this->data['CanteenOrder']['currency_id']); ?></dd>
				<dt>Shipping</dt>
				<dd><?php echo $this->Number->currency($this->data['CanteenOrder']['shipping'],$this->data['CanteenOrder']['currency_id']); ?></dd>
				<dt>Total</dt>
				<dd><?php echo $this->Number->currency($this->data['CanteenOrder']['total'],$this->data['CanteenOrder']['currency_id']); ?></dd>
			</dl>	
		</div>
		<div class='left' > 
			<div class='checkout-header'>
			- CHECKOUT -
			</div>
			<div class='customer-info'>
				<h3 style='text-align:center;'>Shipping Information</h3>
				<?php echo $this->element("checkout-forms/shipping-form"); ?>
			</div>
			<div class='payment-info'>
				<h3 style='text-align:center;'>Payment Information</h3>
				<?php echo $this->element("checkout-forms/cc-form"); ?>
				<?php 
					echo $this->Form->input("same_as_shipping_checkbox",array("type"=>"checkbox","label"=>"Billing Address Same As Shipping",'id'=>'same-as-shipping-check',"div"=>array("id"=>"same-as-shipping-div")));
				?>
				<div style='clear:both;'></div>
					<?php echo $this->element("checkout-forms/billing-form"); ?>
				
				<?php echo $this->Form->submit("Complete Order"); ?>
			</div>
			<div style='clear:both;'></div>
		</div>
		<div style='clear:both;'></div>
	</div>

</div>
<?php 
	echo $this->Form->input("currency_id",array("value"=>$user_currency_id,"type"=>"hidden"));
	echo $this->Form->input("geoip_country_code",array("value"=>env("GEOIP_COUNTRY_CODE"),"type"=>"hidden"));
	echo $this->Form->input("geoip_city",array("value"=>env("GEOIP_CITY"),"type"=>"hidden"));
	echo $this->Form->end(); 
?>

<pre>

<?php 

print_r($this->data);
print_r($this->params);
?>
</pre>


