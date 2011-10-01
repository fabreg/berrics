<div id='canteen-cart-widget'>
		<div class='header-img'></div>
		<div class='account'>My Account</div>
		<div class='cart-items'>
			<div class='item-count'>
				<?php echo count($this->Session->read("CanteenOrder.CanteenOrderItem")); ?>
			</div>
			<div class='cart-link'><a href='/canteen/cart'>View Cart</a></div>
			<div class='cart-icon'></div>
			
			<div style='clear:both;'></div>
		</div>
</div>