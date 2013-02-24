<?php 
if(!isset($fb_meta_img)) {

	$fb_meta_img = '';

}

if(!isset($rss_feed)) {

	$rss_feed = '';

}
?>
<script type='text/javascript'>
		var swfPlayer = "/swf/BerricsPlayer.swf";
	</script>
	<script src="https://ssl.google-analytics.com/urchin.js" type="text/javascript"></script>
	
	<?php
		echo $fb_meta_img;
		echo $rss_feed;
		//echo $this->Html->meta('icon');
		
		
		echo $this->Html->script(array(
			"https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js",
			"https://platform.twitter.com/widgets.js",
			"//ajax.googleapis.com/ajax/libs/jqueryui/1.10.1/jquery-ui.min.js",
			"https://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js",
			"https://connect.facebook.net/en_US/all.js#xfbml=1&appId=128870297181216",
		)); 
		
		if(!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS']!=true) {
			
			echo $this->Html->script(array(
						"http://platform.tumblr.com/v1/share.js"
					));
			
		}
		
		echo $this->Html->script(array(
			"/js/jquery.scrollTo",
			"jquery.swfobject",
			"jquery.client",
			"jquery.form",
			"jquery.ba-bbq",
			"jquery.berrics.login",
			"main"
		
		));
	?>
	<?php 
		echo $this->Html->css(array(
			"main",
			"layout",
			"layout_override",
			"vader/jquery-ui-1.8.11.custom"
		),"stylesheet");
		
		
	?>