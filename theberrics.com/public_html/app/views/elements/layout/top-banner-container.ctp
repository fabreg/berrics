<div id='top-banner-container'>
				
					<?php if(strtoupper(date("D"))=="SUN"): 
					
						$at_link = "/news";

						if(isset($this->params['date_in'])) {
							
							$at_link = "/news/".date("Y")."/".date("m")."/".date("d");
							
						}
					
					?>
						<div style='text-align:center;'>
						<a href='<?php echo $at_link; ?>'>
							<img src='/img/layout/newsv2/Aberrican_Times_BannerTop.jpg' border='0' alt='0'/>
						</a>
						</div>
					<?php else: ?>
					<div class='inner'>
					<div id='top-banner'>
							<?php 
							
								echo $this->element("banner-placements/default-layout-728x90-top");
							
							?>
					</div>
					<div id='top-widget'>
						<?php if($this->theme == "canteen"): ?>
							<?php echo $this->element("canteen/cart-widget"); ?>
						<?php else: ?>
						
						<?php endif; ?>
					</div>
					</div>
					<div class='bottom-edge'>
				
				</div>
					<?php endif; ?>
				
				
</div>