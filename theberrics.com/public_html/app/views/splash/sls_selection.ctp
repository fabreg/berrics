<?php
		$this->Html->script(array(
		
			"http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js",
			"http://connect.facebook.net/en_US/all.js#xfbml=1",
			"http://platform.twitter.com/widgets.js",
			"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js",
			"https://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js",
			"/js/jquery.scrollTo",
			"jquery.swfobject",
			"jquery.client",
			"/js/main.js"
		
		),array("inline"=>false));
		$this->Html->css(array(
			"main",
			"layout",
			"layout_override",
			"vader/jquery-ui-1.8.11.custom"
		
		),"stylesheet",array("inline"=>false));
		$this->set("title_for_layout","The Berrics - The Most Award Winning Skateboarding Site In The World");
?>
<script>

var swfPlayer = "/swf/BerricsPlayer.swf";

</script>
<style>
body {

	background-color:#000;
	background-image:url(/img/splash/sls-selection/bg-2.jpg);
	background-position: center center;
	background-repeat:repeat-y;

}

.d-post-bit .container,.d-post-bit .container-top,.d-post-bit .bottom  {

	background-image:none;
	background-repeat:repeat;

}

.d-post-bit .container-top .display-media {

	margin:auto;

}

.d-post-bit .container-top .title {

	display:none;

}

.d-post-bit .container hr {

	display:none;

}

.d-post-bit .tags {
	
	display:none;

}

.d-post-bit .date-info {

	display:none;

}
.d-post-bit {

	margin-bottom:0px;
	
	
}

.d-post-bit .bottom {

	min-height:0px;

}

coursekillaz (Away)
</style>
<div>
	<div style='width:728px; margin:auto; padding-top:172px; min-height:800px; background-image:url(/img/splash/sls-selection/video-heading-2.png); background-position: top center; background-repeat:no-repeat;'>
		<div style='text-align:center; height:80px;'>
			
		</div>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>

		<div style='text-align:center; padding-top:15px;'>
			<a href='/dailyops' style='color:#ffd204; font-size:32px; font-weight:bold;'>
				- ENTER THE BERRICS - 
			</a>
		</div>
	</div>
</div>