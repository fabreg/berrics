<div id='canteen-order-status'>
	<div class='order-status'>
		<div class='heading'>
			<h1>ORDER STATUS</h1>
		</div>
		<div class='visual'></div>
		<div class='context'>
			
			<!-- Order ID -->
			<div class='text-item' id='order-id'>
				<div class='heading'>ORDER ID:</div>
				<?php echo strtoupper($order['CanteenOrder']['id']); ?>
			</div>
			<!-- Created -->
			<div class='text-item' id='created'>
				<div class='heading'>CREATED:</div>
				<?php echo strtoupper($this->Time->niceShort($order['CanteenOrder']['created'])); ?>
			</div>
			<!-- Modified -->
			<div class='text-item' id='modified'>
				<div class='heading'>LAST UPDATED:</div>
				<?php echo strtoupper($this->Time->niceShort($order['CanteenOrder']['modified'])); ?>
			</div>
			<!-- order status -->
			<div class='text-item' id='order-status'>
				<div class='heading'>ORDER STATUS:</div>
				<?php echo strtoupper($order['CanteenOrder']['order_status']); ?>
			</div>
			
		</div>
	</div>
	<div class='order-notes'>
		<div class='heading'>
			<h1>ORDER NOTES</h1>
		</div>
	</div>
	<div style='clear:both;'></div>
</div>