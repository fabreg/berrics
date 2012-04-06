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
			<div class='items'>
				<table cellspacing='0'>
					<thead>
						<tr>
							<th>VISUAL</th>
							<th><?php echo strtoupper(Lang::instance()->p("CommonFields","items",$user_locale)); ?></th>
							<th><?php echo strtoupper(Lang::instance()->p("CommonFields","price",$user_locale)); ?></th>
						</tr>	
					</thead>
					<tbody>
						<?php foreach($this->data['CanteenOrderItem'] as $k=>$item): ?>
						<tr>
							<td width='2%' align='center' valign='middle' class='product-img'>
								<?php 
							
									foreach($item['ChildCanteenOrderItem'] as $c) {
										
										echo $this->Media->productThumb($c['ParentCanteenProduct']['CanteenProductImage'][0],array("w"=>45,"h"=>45));
										
									}
								?>
							</td>
							<td valign='top' >
								<div class='delete' hash='<?php echo $item['hash']; ?>'>REMOVE</div>
								<?php foreach($item['ChildCanteenOrderItem'] as $key=>$c): ?>
									<div class='item-wrapper'>
										<?php echo $c['ParentCanteenProduct']['name']; ?><?php echo (!empty($c['ParentCanteenProduct']['sub_title'])) ? " - ".$c['ParentCanteenProduct']['sub_title']:""; ?>
										<?php if(!empty($c['CanteenProduct']['opt_label'])): ?> <span class='brand'>BY: <?php echo strtoupper($c['ParentCanteenProduct']['Brand']['name']); ?></span>
										<br /><span class='product-option'><?php echo strtoupper($c['CanteenProduct']['opt_label']); ?>:<?php echo strtoupper($c['CanteenProduct']['opt_value']); ?></span>
										<?php endif; ?>
									</div>
								<?php endforeach; ?>
							</td>
							<td class='price'><?php echo $this->Number->currency($item['sub_total'],$user_currency_id); ?></td>
						</tr>	
						<?php endforeach; ?>
						<tr>
							<td align='center'>
								<img alt='' border='0' src='/img/layout/canteen/ups-logo.png' />
							</td>
							<td colspan='2'>
							<div class='brand'>SHIPPING</div>
							<div>
								<?php echo $this->Form->input("CanteenOrder.shipping_option",array("type"=>"select","options"=>$shipping_codes)); ?>
							</div>
							</td>
							
						</tr>
					</tbody>
				</table>	
			</div>
			<div style='clear:both;'></div>
			<div class='checkout'>
				<div class='totals'>
					<dl class='totals-list'>
						<dt>Sub-Total..</dt>
						<dd id='sub-total-dd'><?php echo $this->Number->currency($this->data['CanteenOrder']['sub_total'],$this->data['CanteenOrder']['currency_id']); ?></dd>
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
								<?php echo $this->element("checkout-forms/billing-form"); ?>
								<div id='grand-total'>
									TOTAL: <span><?php echo $this->Number->currency($this->data['CanteenOrder']['total'],$user_currency_id); ?></span>
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