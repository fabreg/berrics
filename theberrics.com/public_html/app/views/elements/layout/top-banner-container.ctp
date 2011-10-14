<div id='top-banner-container'>
				<div class='inner'>
					<div id='top-banner'>
							<?php 
							
								echo $this->element("banner-placements/default-layout-728x90-top");
							
							?>
					</div>
					<div id='top-widget'>
						<?php if($this->theme == "canteen"): ?>
							<?php echo $this->element("canteen/cart-widget"); ?>
						<?php endif; ?>
					</div>
				</div>
				<div class='bottom-edge'>
				
				</div>
</div>