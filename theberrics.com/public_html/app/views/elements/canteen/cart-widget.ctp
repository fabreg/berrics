<div id='canteen-cart-widget'>
		<div class='header-img'>
			<a href='/canteen' title='The Berrics Canteen'><img border='0' src='/img/layout/canteen/cart/cart-widget-heading.jpg' /></a>
		</div>
		<div class='account'>
			<?php if(!$this->Session->check("Auth.User.id")): ?>
			<a href='' rel='cart-login' callback='<?php echo base64_encode("/account"); ?>'>Sign In</a><?php else: ?><a href='/account/canteen'>My Account</a>|<a href='/identity/login/logout/<?php echo base64_encode($this->here); ?>'>Logout</a><?php endif; ?>|<a href='/canteen/support' title='The Berrics Canteen Support: Check The Status Of Your Order Or Ask A Question'>Customer Service</a>
		</div>
		<div style='clear:both;'></div>
		<div class='cart-items'>
			<div class='item-count'>
				<?php echo count($this->Session->read("CanteenOrder.CanteenOrderItem")); ?>
			</div>
			<span class='phone-number'>&nbsp;&nbsp;<!-- 877-235-0490 --></span> <div class='cart-link'><a href='/canteen/cart'>View Cart</a></div>
			<div class='cart-icon'></div>
			<div style='clear:both;'></div>
		</div>
</div>