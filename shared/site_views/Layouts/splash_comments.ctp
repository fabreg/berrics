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
<html xmlns:fb="http://www.facebook.com/2008/fbml">
	<head>
		<title><?php echo $title_for_layout; ?></title>
		<meta http-equiv="X-UA-Compatible" content="IE=edge" >
		<META name="description" content="<?php echo $meta_d?>"> 
		<META name="keywords" content="<?php echo $meta_k?>"> 
		<style type='text/css'>
			<?php echo $page['SplashPage']['css']; ?>
		</style>
		<script type='text/javascript'>
			<?php echo $page['SplashPage']['javascript']; ?>
		</script>
	</head>
	<body>
		<?php 

		
			echo $content_for_layout;
		
		
		?>
	</body>
</html>