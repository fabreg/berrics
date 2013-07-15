<div id="unified-store-profile">
	<div id="profile-header" class='clearfix'>
		<div class="left">
			<img src="/theme/unified/img/profile-header-left.png" alt="">
		</div>
		<div class="right">
			<img src="/theme/unified/img/profile-header-right.png" alt="">
		</div>
		<div class="center">
			SHOP PROFILE
		</div>
	</div>
	<div class="profile-body-container clearfix">
		<div class="top-info">
			<div class="left clearfix">
				<div class="shop-name">
					<?php echo $store['UnifiedStore']['shop_name']; ?>
				</div>
				<div class="logo">
					<?php if (!empty($store['UnifiedStore']['image_logo'])): ?>
						  	<img src="//img.theberrics.com/i.php?src=/unified-logos/<?php echo $store['UnifiedStore']['image_logo']; ?>&w=100" alt="">
					<?php endif; ?>
					<div class="open-closed">
						<span class="open">OPEN</span>
					</div>
				</div>
				<div class="store-details">
					<div class="street-address">
						<div><?php echo $store['UnifiedStore']['address1'];  ?> <?php echo $store['UnifiedStore']['address2'];  ?></div>
						<div><?php echo $store['UnifiedStore']['city']; ?>, <?php echo $store['UnifiedStore']['state']; ?> <?php echo $store['UnifiedStore']['zip']; ?></div>
						<div><?php echo $store['UnifiedStore']['phone']; ?></div>
					</div>
				</div>
			</div>
			<div class="right">
				
			</div>
		</div>
	</div>
</div>
<pre>
<?php print_r($store); ?>
</pre>