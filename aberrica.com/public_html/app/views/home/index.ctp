<?php

	 $this->Html->css("home","stylesheet",array("inline"=>false));

?>
<div id='home-main-banner'>
	<?php echo $this->Html->image("image.jpg"); ?>
</div>
<div id='aberrica-home'>
	<div class='left-col'>
		<!-- Banner Ad -->
		<?php echo $this->element("banners/home-news-top-624x90"); ?>
		<div class='news-header'>
			News Feed		
		</div>
		<?php 
		
			foreach($articles as $a) {
				
				echo $this->element("home/main-news-bit",array("article"=>$a));
				
			}
		
		?>
	</div>
	<div class='right-col'>
	<!-- Banner -->
		<?php echo $this->element("banners/right-col-300x250"); ?>
		<div class='featured-bloggers-header'>
			Featured Blog Posts
		</div>
		<!--  Output some users -->
		<?php 
		
			foreach($featured_bloggers as $user) {
				
				echo $this->element("home/featured-blogger-bit",array("user"=>$user));
				
			}
		
		?>
	</div>
	<div style='clear:both;'></div>
</div>