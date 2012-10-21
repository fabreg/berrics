<?php


?>

<div id='section-year-menu'>
	<ul>
	<?php 
	
		foreach($years as $y):
		
		if($year == $y) {
			
			$class = 'class="selected"';
			
		} else {
			
			$class = '';
			
		}
		
	?>
	
		<li <?php echo $class; ?> >
			<a href='/<?php echo $this->params['section']; ?>/<?php echo $y;?>'>
				<?php echo $y; ?>
			</a>
		</li>
	
	<?php 
	
		endforeach;
	
	?>
	</ul>
	<div style='clear:both;'></div>
</div>