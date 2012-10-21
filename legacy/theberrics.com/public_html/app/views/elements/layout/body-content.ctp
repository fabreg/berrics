<div id='right-col'>
	
	<?php 
		
		if(isset($right_column)) {
			
			echo $right_column;
			
		} else {
			
			echo $this->element("layout/right-banners");
			
		}
		
		
	
	?>
</div>
<div id='left-col'>
	<div id='body-content'>
			<?php echo $this->Session->flash(); ?>
			<?php echo $content_for_layout; ?>
	</div>
</div>