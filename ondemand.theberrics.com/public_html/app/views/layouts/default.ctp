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
	<?php echo $this->Html->charset(); ?>
	<title>The Berrics - <?php echo $title_for_layout; ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" >
	<META name="description" content="<?php echo $meta_d?>"> 
	<META name="keywords" content="<?php echo $meta_k?>"> 
	<script type='text/javascript'>
		var swfPlayer = "/swf/BerricsPlayer.swf";
	</script>
	<script src="http://www.google-analytics.com/urchin.js" type="text/javascript"></script>
	
	<?php
		echo $fb_meta_img;
		echo $rss_feed;
		//echo $this->Html->meta('icon');
		
		echo $this->Html->script(array(
		
			"http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js",
			"http://connect.facebook.net/en_US/all.js#xfbml=1",
			"http://platform.twitter.com/widgets.js",
			"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js",
			"/js/jquery.scrollTo",
			"jquery.swfobject",
			"jquery.client"
		
		));
	?>
	<script type='text/javascript' src='/js/main.js?2011-07-15'></script>
	<?php 
		echo $this->Html->css(array(
			"main",
			"layout",
			"layout_override",
			"vader/jquery-ui-1.8.11.custom"
		
		),"stylesheet");
		
		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id='main-container'>
		<div id='page-container'>
			<div id='header-container'></div>
			<div id='body-container'><?php echo $content_for_layout; ?></div>
			<div id='footer-container'></div>
		</div>
	</div>
	<div style='font-size:9px; text-align:right;'>
		<?php echo php_uname("n"); ?>
	</div>
	<?php echo $this->element('sql_dump'); ?>
	<!-- 8=D JH :-) 2011-06-20 -->
</body>
</html>