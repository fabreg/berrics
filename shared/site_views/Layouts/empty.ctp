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
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name='keywords' content="<?php echo $meta_k; ?>" >
	<meta name='decsription' content="<?php echo $meta_d; ?>" >
	<meta property="fb:app_id" content="128870297181216">
	<meta property="og:url" content="http://theberrics.com<?php echo $_SERVER['REQUEST_URI']; ?>">
	<meta property="og:type" content="website">
	<?php 
		echo $fb_meta_img;
		echo $this->element("layout/v3/html-head-scripts");
		//echo $scripts_for_layout;
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<body>
		<?php echo $content_for_layout; ?>
		<?php echo $this->element('sql_dump'); ?>
		<?php echo $this->element("layout/v3/html-footer-scripts"); ?>
		<!-- The Berrics - June 16 2011 - NOW() - John.hardy@me.com -->
	</body>
</html>