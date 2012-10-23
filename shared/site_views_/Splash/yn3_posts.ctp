<?php
		$this->theme = "yn3-finals";
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

$(document).ready(function() { 




	
});

</script>
<style>
body {

	background-image:url(/img/splash/yn3splash/bg.jpg);
	background-position:top center;
	
}

.post {

	width:728px;
	margin:auto;
	
}
.enter {

	padding:10px;
	text-align:center;

}

.enter a {

	color:#000;
	font-size:28px;

}
</style>
<div style='height:35px;'></div>
<div class='post'>
	<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
</div>
<div class='enter'>
	<a href='/dailyops'>
		- ENTER THE BERRICS -
	</a>
</div>