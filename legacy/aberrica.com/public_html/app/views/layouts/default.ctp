<?php 

	if(!isset($meta_d)) {
		
		$meta_d = "";
		
	}

	if(!isset($meta_k)) {
		
		$meta_k = "";
		
	}
	
	if(!isset($fb_meta_img)) {
		
		$fb_meta_img = '';
		
	}
	
	if(!isset($rss_feed)) {
		
		$rss_feed = '';
		
	}
	

?>
<!DOCTYPE html>
<html>
<head>
	<title>
		aberrica | <?php echo $title_for_layout; ?>
	</title>
		<META name="description" content="<?php echo $meta_d?>"> 
	<META name="keywords" content="<?php echo $meta_k?>"> 
	<?php 
	
		echo $this->Html->css(array(
			"layout"
		),"stylesheet");
		
		echo $this->Html->script(array(
		
			"http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js",
			"http://connect.facebook.net/en_US/all.js#xfbml=1",
			"http://platform.twitter.com/widgets.js",
			"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"
		
		));
	
	?>
	<?php 
	
		echo $scripts_for_layout;
	
	?>
</head>
<body>
<div id='main-container'>
	<div id='page-wrapper-left'>
		<div id='page-wrapper-right'>
			<div id='page-container'>
				<div id='header-container'>
					<div class='top-bar'>
					<?php 
					
						if($this->Session->check("Auth.User.id")) {
							
							echo $this->element("profile-nav");
							
						} else {
							
							echo $this->element("signin");
							
						}
					
					?>
					</div>
					<div id='header'>
						<div class='header-logo'>
							Aberrica Logo
						</div>
						<div class='main-nav-container'>
							<span class='main-nav'>
								<?php 
								
									echo $this->element("topNav",array("topNav"=>$topNav));
								
								?>
							</span>
						</div>
					</div>
				</div>
				<div id='body-container'>
					<div id='body-content'>
						<?php 
	
							echo $content_for_layout;
						
						?>
					</div>
				</div>
				<div id='footer-container'>
					<div id='footer'>
					
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
<?php //echo $this->element("sql_dump"); ?>
</html>