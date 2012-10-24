<div id='profile-body'>
	<div class='profile-details-widget'>
		<?php 
			echo $this->element("profiles/main-details");	
		?>
	</div>
	<div class='profile-nav'>
	
	</div>
	<div class='profile-content'>
		<?php 
		
		echo $content_for_layout;
		
		?>
	</div>
	<div style='clear:both;'></div>
</div>