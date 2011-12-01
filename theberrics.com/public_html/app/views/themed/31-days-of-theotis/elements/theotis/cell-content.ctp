<div class='theotis-cell-content'>
	<div class='day'><?php echo $day; ?></div>
	<?php 
	
		if(!isset($p['Dailyop']['id'])):
	
	?>
	
	<div class='inactive'>
		
	</div>
	<?php else: //die(print_r($p)); ?>
		<?php if(isset($p['Dailyop']['found']) && $p['Dailyop']['found'] == 1): ?>
			
			<div class='found'>
				<a href='/31-days-of-theotis/<?php echo $p['Dailyop']['uri']; ?>'>
					<img alt='' border='0' src='/theme/31-days-of-theotis/img/clear.png' height='100%' width='100%' />
				</a>
			</div>
		<?php else:?>	
			<div class='active'>
				<a href='/31-days-of-theotis/<?php echo $p['Dailyop']['uri']; ?>'>
					<img alt='' border='0' src='/theme/31-days-of-theotis/img/clear.png' height='100%' width='100%' />
				</a>
			</div>
		<?php endif;?>
	<?php endif; ?>
</div>