<script type='text/javascript'>
		var swfPlayer = "/swf/BerricsPlayer.swf";
	</script>
	<script src="https://ssl.google-analytics.com/urchin.js" type="text/javascript"></script>
	
	<?php
		echo $fb_meta_img;
		echo $rss_feed;
		//echo $this->Html->meta('icon');
		
		
		echo $this->Html->script(array(
			"https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js",
			"https://www.google.com/uds?file=ima&v=1&nodependencyload=true",
			"https://platform.twitter.com/widgets.js",
			"https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js",
			"https://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js",
			"https://connect.facebook.net/en_US/all.js#xfbml=1",
		));
		
		if($_SERVER['HTTPS']!=true) {
			
			echo $this->Html->script(array(
						"http://platform.tumblr.com/v1/share.js"
					));
			
		}
		
		echo $this->Html->script(array(
			"json2",
			"modernizr",
			"/js/jquery.scrollTo",
			"jquery.swfobject",
			"jquery.client",
			"jquery.form",
			'jquery.fullscreen',
			"berrics.htmlvideo",
			"main"
		
		));
	?>
	<?php 
		echo $this->Html->css(array(
			"main",
			"layout",
			"BerricsHtmlVideo",
			"layout_override",
			"vader/jquery-ui-1.8.11.custom"
		),"stylesheet");
		
		
	?>