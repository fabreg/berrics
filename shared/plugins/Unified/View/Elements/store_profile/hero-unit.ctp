<div id='unified-store-hero'>
	<h1><?php echo strtoupper($store['UnifiedStore']['shop_name']); ?></h1>
	<div class="info-div clearfix row-fluid">
		<div class="span6">
			<div class='info-frag'>
				<strong>Address:</strong> 
				<?php echo $store['UnifiedStore']['address1'] ?> 
				<?php echo $store['UnifiedStore']['address2'] ?> 
				<?php echo $store['UnifiedStore']['city'] ?> 
				<?php echo $store['UnifiedStore']['state'] ?>, <?php echo $store['UnifiedStore']['country'] ?>  
				<?php echo $store['UnifiedStore']['zip'] ?>  
			</div>
			<div class='info-frag'>
				<strong>Phone:</strong> 
				<?php echo $store['UnifiedStore']['phone'] ?> 
			</div>
			<div class='info-frag'>
				<strong>Email:</strong> 
				<?php echo $store['UnifiedStore']['phone'] ?> 
			</div>
		</div>
		<div class="span6">
			<div class='info-frag'>
				<strong>Year Established:</strong> 
				<?php echo $store['UnifiedStore']['established_year'] ?> 
			</div>
		</div>

	</div>
</div>