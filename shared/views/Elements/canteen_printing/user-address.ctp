<div class='UserAddress'>
	<?php if(isset($heading)): ?>
	<div class='heading'>
		<?php echo $heading; ?>
	</div>
	<?php endif; ?>
	<div class='name'><?php echo $ua['first_name']; ?> <?php echo $ua['last_name']; ?></div>
	<div class='street'><?php echo $ua['street']; ?> <?php echo $ua['apt']; ?></div>
	<div class='city'><?php echo $ua['city']; ?>, <?php echo $ua['state']; ?> <?php echo $ua['postal_code']; ?> <?php echo $ua['country_code']; ?></div>
	<?php if($ua['address_type'] == "shipping"): ?>
		<div class='phone'><?php echo $ua['phone']; ?></div>
	<?php endif; ?>
</div>