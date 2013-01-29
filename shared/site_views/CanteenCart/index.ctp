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

<div id="canteen-cart" class='column-shadow'>
	<div class="large-heading">
		<h1>
			The Canteen // Shopping Cart
		</h1>
	</div>
	<div class="continue-shopping">
		<a href="/canteen" class="btn">CONTINUE SHOPPING</a>
	</div>
	<?php echo $this->element("canteen_cart/items-table"); ?>
	<div class="checkout-row clearfix ">
		<!-- totals cell -->
		<div class="totals-cell">
			<div class='totals' width='100%' cellspacing='0'>
				<table class='table table-striped table-bordered'>
					<?php if($this->request->data['CanteenOrder']['currency_id']!="USD"): ?>
					<tr>
						<td colspan='2'>
							Amounts shown are in <?php echo $this->request->data['CanteenOrder']['currency_id']; ?>
						</td>
					</tr>
					<?php endif; ?>
					<?php if($this->request->data['CanteenOrder']['discount_total']<0): ?>
					<tr>
						<td class='discount-total-label'>Discount</td>
						<td id='discount-total-dd'><?php echo number_format($this->request->data['CanteenOrder']['discount_total'],2); ?></td>
					</tr>
					<?php endif; ?>
					<tr>
						<td>Sub Total</td>
						<td id='sub-total-dd'><?php echo $this->Berrics->currency($this->request->data['CanteenOrder']['sub_total'],$this->request->data['CanteenOrder']['currency_id']); ?></td>
					</tr>
					<tr>
						<td>Sales Tax</td>
						<td id='tax-total-dd'><?php echo $this->Berrics->currency($this->request->data['CanteenOrder']['tax_total'],$this->request->data['CanteenOrder']['currency_id']); ?></td>
					</tr>
					<tr>
						<td>Shipping</td>
						<td id='shipping-total-dd'><?php echo $this->Berrics->currency($this->request->data['CanteenOrder']['shipping_total'],$this->request->data['CanteenOrder']['currency_id']); ?></td>
					</tr>
					<tr>
						<td>Grand Total</td>
						<td id='grand-total-dd'><?php echo $this->Berrics->currency($this->request->data['CanteenOrder']['grand_total'],$this->request->data['CanteenOrder']['currency_id']); ?></td>
					</tr>
				</table>
			</div>
		</div>
		<!-- Check form -->
		<div class="checkout-form well well-small ">
			<?php echo $this->Form->create("CanteenOrder",array("url"=>$this->request->here,"id"=>"checkout-form","class"=>"form form-horizontal")); ?>
			<div class="row-fluid">
				<div class="span12">
					<div class="large-heading">
						<h1>Checkout Form</h1>
					</div>
				</div>
			</div>
			<div class="row-fluid">
				<div class='span6 shipping'>
					<h3><?php echo strtoupper($l['shipaddress']); ?></h3>
					<?php echo $this->Form->input("CanteenOrder.shipping_method",array("type"=>"hidden","label"=>"Method","value"=>"standard")); ?>
					<?php echo $this->element("checkout-forms/shipping-address",array("index"=>0,"address_type"=>"shipping")); ?>
				</div>
				<div class=' span6 billing'>
					<h3>PAYMENT INFORMATION </h3>
					<div class='cc-icons'>
						<img border='0' src='/img/layout/canteen/cart/card-icons.png' style='margin-top:-16px;'>
					</div>
					<?php echo $this->element("checkout-forms/cc-form"); ?>
					<h3>BILLING ADDRESS</h3>

						<div class="same-as-shipping-div">

							<label><?php echo $this->Form->checkbox("CanteenOrder.same_as_shipping_checkbox",array("id"=>"same-as-shipping-check")); ?> Same As Shipping</label>

						</div>
						<?php 
							//echo $this->Form->input("same_as_shipping_checkbox",array("type"=>"checkbox","label"=>" Same As Shipping",'id'=>'same-as-shipping-check',"div"=>array("id"=>"same-as-shipping-div")));
						?>
					
					<div style='clear:both;'></div>
					<div id='billing-form'><?php echo $this->element("checkout-forms/billing-address",array("index"=>1,"address_type"=>"billing")); ?></div>
					<div id='grand-total'>
						TOTAL: <span><?php echo $this->Berrics->currency($this->request->data['CanteenOrder']['grand_total'],$user_currency_id); ?></span>
					</div>
					
					<?php echo $this->Form->submit("COMPLETE ORDER",array("class"=>"btn btn-success","id"=>"checkout-submit")); ?>
				</div>
			</div>
			<?php 
				if($this->Session->check("Auth.User.id")) echo $this->Form->input("user_id",array("type"=>"hidden","value"=>$this->Session->read("Auth.User.id")));
				echo $this->Form->input("currency_id",array("value"=>$user_currency_id,"type"=>"hidden"));
				echo $this->Form->input("geoip_country_code",array("value"=>env("GEOIP_COUNTRY_CODE"),"type"=>"hidden"));
				echo $this->Form->input("geoip_city",array("value"=>env("GEOIP_CITY"),"type"=>"hidden"));
				echo $this->Form->end(); ?>
		</div>	
	</div>
</div>



<pre>
<?php 

//echo "Country: ".env("GEOIP_COUNTRY_CODE");
//print_r($this->request->data);
//print_r($this->Session->read());
//print_r($this->request->params);
print_r(CakeSession::read("CanteenOrder"))
?>
</pre>