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
		<meta property="fb:app_id" content="128870297181216"/>
		
		<?php 
		
			echo $this->Html->script(array(
		
				"https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js",
				"https://platform.twitter.com/widgets.js",
				"https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js",
				"/js/jquery.scrollTo",
				"jquery.swfobject",
				"jquery.client",
				"main"
		
			));
		
		?>
		<?php echo $scripts_for_layout; ?>
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