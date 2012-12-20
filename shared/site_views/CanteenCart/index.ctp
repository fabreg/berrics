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
	<div class="heading">
		<h2>The Canteen // Shopping Cart</h2>
	</div>
	<?php echo $this->element("canteen_cart/items-table"); ?>
	<div class="checkout-row clearfix ">
		<!-- totals cell -->
		<div class="totals-cell">
			<div class='totals'>
				<table>
					<?php if($this->request->data['CanteenOrder']['currency_id']!="USD"): ?>
					<tr>
						<td colspan='2'>
							Amounts shown are in <?php echo $this->request->data['CanteenOrder']['currency_id']; ?>
						</td>
					</tr>
					<?php endif; ?>
					<?php if($this->request->data['CanteenOrder']['discount_total']<0): ?>
					<tr>
						<td class='discount-total-label'>Discount...</td>
						<td id='discount-total-dd'><?php echo number_format($this->request->data['CanteenOrder']['discount_total'],2); ?></td>
					</tr>
					<?php endif; ?>
					<tr>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
					</tr>
				</table>

				<dl class='totals-list dl-horizontal'>
					
					
					<dt>Sub-Total..</dt>
					<dd id='sub-total-dd'><?php echo $this->Berrics->currency($this->request->data['CanteenOrder']['sub_total'],$this->request->data['CanteenOrder']['currency_id']); ?></dd>
					<dt id='tax-total-dt'>Sales-Tax..</dt>
					<dd id='tax-total-dd'><?php echo $this->Berrics->currency($this->request->data['CanteenOrder']['tax_total'],$this->request->data['CanteenOrder']['currency_id']); ?></dd>
					<dt>Shipping...</dt>
					<dd id='shipping-total-dd'><?php echo $this->Berrics->currency($this->request->data['CanteenOrder']['shipping_total'],$this->request->data['CanteenOrder']['currency_id']); ?></dd>
					<dt class='grand-total-label'>Total......</dt>
					<dd id='grand-total-dd'><?php echo $this->Berrics->currency($this->request->data['CanteenOrder']['grand_total'],$this->request->data['CanteenOrder']['currency_id']); ?></dd>
				</dl>
			</div>
		</div>
		<!-- Check form -->
		<div class="checkout-form well well-small ">
			<?php echo $this->Form->create("CanteenOrder",array("url"=>$this->request->here,"id"=>"checkout-form","class"=>"form form-horizontal")); ?>
			<div class="row-fluid">
				<div class="span12">
					<h2>Checkout Form</h2>
				</div>
			</div>
			<div class="row-fluid">
				<div class='span6 shipping'>
					<h3><?php echo strtoupper($l['shipaddress']); ?></h3>
					<?php echo $this->Form->input("CanteenOrder.shipping_method",array("type"=>"hidden","label"=>"Method","value"=>"standard")); ?>
					<?php echo $this->element("checkout-forms/shipping-address",array("index"=>0,"address_type"=>"shipping")); ?>
				</div>
				<div class=' span6 billing'>
					<h3>PAYMENT INFORMATION <br /><img border='0' src='/img/layout/canteen/cart/card-icons.png' style='margin-top:-16px;'></h3>
					<?php echo $this->element("checkout-forms/cc-form"); ?>
					<?php 
						echo $this->Form->input("same_as_shipping_checkbox",array("type"=>"checkbox","label"=>"Billing Address Same As Shipping",'id'=>'same-as-shipping-check',"div"=>array("id"=>"same-as-shipping-div")));
					?>
					<div style='clear:both;'></div>
					<div id='billing-form'><?php echo $this->element("checkout-forms/billing-address",array("index"=>1,"address_type"=>"billing")); ?></div>
					<div id='grand-total'>
						TOTAL: <span><?php echo $this->Berrics->currency($this->request->data['CanteenOrder']['grand_total'],$user_currency_id); ?></span>
					</div>
					
					<?php echo $this->Form->submit("COMPLETE ORDER"); ?>
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
print_r($this->request->params);
?>
</pre>