<?php 

$this->Html->script(array("cart/index","jquery.form"),array("inline"=>false));

$shipping_codes = CanteenConfig::get("shipping_codes");



?>
<?php echo $this->Form->create("CanteenOrder",array("url"=>$this->here,"id"=>"checkout-form")); ?>
<div id='canteen-cart'>
	<div class='header'>
		<h1>THE CANTEEN // SHOPPING CART</h1>
		<div style='padding-left:85px; padding-top:5px;'>
			<a href='/canteen'>
				<img border='0' alt='' src='/img/layout/canteen/cart/continue-shopping.png'/>
			</a>
		</div>
	</div>
	<div class='container'>
		<div class='container-top'>
			<?php echo $this->element("canteen_cart/items-table"); ?>
			<div style='clear:both;'></div>
			<div class='checkout'>
				<div class='totals'>
					<dl class='totals-list'>
						<dt>Sub-Total..</dt>
						<dd id='sub-total-dd'><?php echo $this->Number->currency($this->data['CanteenOrder']['sub_total'],$this->data['CanteenOrder']['currency_id']); ?></dd>
						<dt id='tax-total-dt'>Sales-Tax..</dt>
						<dd id='tax-total-dd'><?php echo $this->Number->currency($this->data['CanteenOrder']['tax_total'],$this->data['CanteenOrder']['currency_id']); ?></dd>
						<dt>Shipping...</dt>
						<dd id='shipping-dd'><?php echo $this->Number->currency($this->data['CanteenOrder']['shipping_total'],$this->data['CanteenOrder']['currency_id']); ?></dd>
						<dt class='grand-total-label'>Total......</dt>
						<dd id='grand-total-dd'><?php echo $this->Number->currency($this->data['CanteenOrder']['grand_total'],$this->data['CanteenOrder']['currency_id']); ?></dd>
					</dl>
				</div>
				<div class='form'>
					<div class='container'>
						<div class='container-top'>
							<div class='heading'>
								<h2>CHECKOUT</h2>
							</div>
							<div class='shipping'>
								<h3>SHIPPING INFORMATION</h3>
								<?php echo $this->element("checkout-forms/shipping-form",array("index"=>"shipping")); ?>
							</div>
							<div class='billing'>
								<h3>PAYMENT INFORMATION</h3>
								<?php echo $this->element("checkout-forms/cc-form"); ?>
								<?php 
									echo $this->Form->input("same_as_shipping_checkbox",array("type"=>"checkbox","label"=>"Billing Address Same As Shipping",'id'=>'same-as-shipping-check',"div"=>array("id"=>"same-as-shipping-div")));
								?>
								<div style='clear:both;'></div>
								<?php echo $this->element("checkout-forms/shipping-form",array("index"=>"billing")); ?>
								<div id='grand-total'>
									TOTAL: <span><?php echo $this->Number->currency($this->data['CanteenOrder']['grand_total'],$user_currency_id); ?></span>
								</div>
								<?php echo $this->Form->submit("COMPLETE ORDER"); ?>
							</div>
							<div style='clear:both;'></div>
						</div>
					</div>
					<div class='form-bottom'></div>
				</div>
			</div>
			<div style='clear:both;'></div>
		</div>
	</div>
	<div>
		<img border='0' alt='' src='/img/layout/canteen/cart/cart-bottom.jpg' />
	</div>
</div>
<?php 
	if($this->Session->check("Auth.User.id")) echo $this->Form->input("user_id",array("type"=>"hidden","value"=>$this->Session->read("Auth.User.id")));
	echo $this->Form->input("currency_id",array("value"=>$user_currency_id,"type"=>"hidden"));
	echo $this->Form->input("geoip_country_code",array("value"=>env("GEOIP_COUNTRY_CODE"),"type"=>"hidden"));
	echo $this->Form->input("geoip_city",array("value"=>env("GEOIP_CITY"),"type"=>"hidden"));
echo $this->Form->end(); ?>
<?php 


pr($this->data);


?>