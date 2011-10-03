<div id='canteen-cart-widget'>
		<div class='header-img'></div>
		<div class='account'>
			<?php if(!$this->Session->check("Auth.User.id")): ?>
			<a href='' rel='cart-login' callback='<?php echo base64_encode("/account"); ?>'>Login To Your Account</a>
			<?php else: ?>
			<a>My Account</a> | <a href='/identity/login/logout/<?php echo base64_encode($this->here); ?>'>Logout</a>
			<?php endif; ?>
		</div>
		<div class='cart-items'>
			<div class='item-count'>
				<?php echo count($this->Session->read("CanteenOrder.CanteenOrderItem")); ?>
			</div>
			<div class='cart-link'><a href='/canteen/cart'>View Cart</a></div>
			<div class='cart-icon'></div>
			<div style='clear:both;'></div>
		</div>
</div>