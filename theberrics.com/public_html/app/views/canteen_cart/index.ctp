<?php 

$this->Html->script(array("cart/index"),array("inline"=>false))

?>
<?php echo $this->Form->create("CanteenOrder",array("url"=>$this->here)); ?>
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
							<th><?php echo strtoupper(Lang::instance()->p("CommonFields","qty",$user_locale)); ?></th>
							<th><?php echo strtoupper(Lang::instance()->p("CommonFields","price",$user_locale)); ?></th>
						</tr>	
					</thead>
					<tbody>
						<?php foreach($this->data['CanteenOrderItem'] as $k=>$item): ?>
						<tr>
							<td width='2%' align='center' valign='middle' class='product-img'>
								<?php 
							
									$img = Set::extract("/CanteenProductImage[thumb_image=1]",$item);
									
									if(count($img)<=0) {
										
										$img = Set::extract("/CanteenProductImage[front_image=1]",$item);
										
									}
									
									echo $this->Media->productThumb($img[0]['CanteenProductImage'],array("h"=>47,"w"=>47));
									
									echo $this->Form->input("CanteenOrderItem.{$k}.canteen_product_id",array("type"=>"hidden","value"=>$item['CanteenProduct']['id']));
									echo $this->Form->input("CanteenOrderItem.{$k}.canteen_product_option_id",array("type"=>"hidden","value"=>$item['CanteenProductOption'][0]['id']));
									echo $this->Form->input("CanteenOrderItem.{$k}.quantity",array("type"=>"hidden","value"=>$item['CanteenOrderItem'][0]['quantity']));
									
								?>
							</td>
							<td valign='top' >
								<div class='item-wrapper'>
									<div class='delete' hash='<?php echo $item['hash']; ?>'>REMOVE</div>
									<span class='brand'><?php echo strtoupper($item['Brand']['name']); ?></span>
									<br />
									<?php echo $item['CanteenProduct']['name']; ?><?php echo (!empty($item['CanteenProduct']['sub_title'])) ? " - ".$item['CanteenProduct']['sub_title']:""; ?>
									<?php if(isset($item['CanteenProductOption'][0]['id'])): ?>
									<br /><span class='product-option'><?php echo strtoupper($item['CanteenProductOption'][0]['opt_label']); ?>:<?php echo strtoupper($item['CanteenProductOption'][0]['opt_value']); ?></span>
									<?php endif; ?>
								</div>
							</td>
							<td align='center' class='qty'><?php echo $item['quantity']; ?></td>
							<td class='price'><?php echo $this->Number->currency($item['price'],$user_currency_id); ?></td>
						</tr>	
						<?php endforeach; ?>
						<tr>
							<td align='center'>
								<img alt='' border='0' src='/img/layout/canteen/ups-logo.png' />
							</td>
							<td colspan='3'>
							<div class='brand'>SHIPPING</div>
							<div>
							<?php echo $this->Form->input("CanteenOrder.shipping_option",array("type"=>"select")); ?>
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
						<dd><?php echo $this->Number->currency($this->data['CanteenOrder']['total'],$this->data['CanteenOrder']['currency_id']); ?></dd>
						<dt>Shipping...</dt>
						<dd><?php echo $this->Number->currency($this->data['CanteenOrder']['shipping'],$this->data['CanteenOrder']['currency_id']); ?></dd>
						<dt class='grand-total-label'>Total......</dt>
						<dd class='grand-total'><?php echo $this->Number->currency($this->data['CanteenOrder']['total'],$this->data['CanteenOrder']['currency_id']); ?></dd>
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
								<?php echo $this->element("checkout-forms/shipping-form"); ?>
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