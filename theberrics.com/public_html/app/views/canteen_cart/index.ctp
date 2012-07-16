<?php 

$this->Html->script(array("cart/index","jquery.form"),array("inline"=>false));
$shipping_codes = array(
	"standard"=>"Standard",
	"expedited"=>"Expedited"
);
$l = Lang::returnSection("CommonFields",$user_locale);

$skip_currency_alert = true;

$skip = array();

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
						<?php if($this->data['CanteenOrder']['currency_id']!="USD"): ?>
						<div style='font-size:12px; font-style:italic; text-align:center;'>Amounts shown are in <?php echo $this->data['CanteenOrder']['currency_id']; ?></div>
						<?php endif; ?>
						<?php if($this->data['CanteenOrder']['discount_total']<0): ?>
						<dt class='discount-total-label'>Discount...</dt>
						<dd id='discount-total-dd'><?php echo number_format($this->data['CanteenOrder']['discount_total'],2); ?></dd>
						<?php endif; ?>
						<dt>Sub-Total..</dt>
						<dd id='sub-total-dd'><?php echo $this->Berrics->currency($this->data['CanteenOrder']['sub_total'],$this->data['CanteenOrder']['currency_id']); ?></dd>
						<dt id='tax-total-dt'>Sales-Tax..</dt>
						<dd id='tax-total-dd'><?php echo $this->Berrics->currency($this->data['CanteenOrder']['tax_total'],$this->data['CanteenOrder']['currency_id']); ?></dd>
						<dt>Shipping...</dt>
						<dd id='shipping-total-dd'><?php echo $this->Berrics->currency($this->data['CanteenOrder']['shipping_total'],$this->data['CanteenOrder']['currency_id']); ?></dd>
						<dt class='grand-total-label'>Total......</dt>
						<dd id='grand-total-dd'><?php echo $this->Berrics->currency($this->data['CanteenOrder']['grand_total'],$this->data['CanteenOrder']['currency_id']); ?></dd>
					</dl>
				</div>
				<div class='form'>
					<div><?php echo $this->Session->flash(); ?></div>
					<div class='container'>
						<div class='container-top'>
							<div class='heading'>
								<h2><img src='/img/layout/canteen/cart/cart-lock-icon.png' border='0' />CHECKOUT</h2>
								
							</div>
							<div class='shipping'>
								<h3>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo strtoupper($l['shipaddress']); ?></h3>
								<?php echo $this->Form->input("CanteenOrder.shipping_method",array("type"=>"hidden","label"=>"Method","value"=>"standard")); ?>
								<?php echo $this->element("checkout-forms/shipping-address",array("index"=>0,"address_type"=>"shipping")); ?>
							</div>
							<div class='billing'>
								<h3>PAYMENT INFORMATION <img border='0' src='/img/layout/canteen/cart/card-icons.png' style='margin-top:-16px;'></h3>
								
								<?php echo $this->element("checkout-forms/cc-form"); ?>
								<?php 
									echo $this->Form->input("same_as_shipping_checkbox",array("type"=>"checkbox","label"=>"Billing Address Same As Shipping",'id'=>'same-as-shipping-check',"div"=>array("id"=>"same-as-shipping-div")));
								?>
								<div style='clear:both;'></div>
								<div id='billing-form'><?php echo $this->element("checkout-forms/billing-address",array("index"=>1,"address_type"=>"billing")); ?></div>
								<div id='grand-total'>
									TOTAL: <span><?php echo $this->Berrics->currency($this->data['CanteenOrder']['grand_total'],$user_currency_id); ?></span>
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
<pre>
<?php 

echo "Country: ".env("GEOIP_COUNTRY_CODE");
//print_r($this->data);
//print_r($this->Session->read());

?>
</pre>