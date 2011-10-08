<?php
		$this->Html->script(array(
		
			"http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js",
			"http://connect.facebook.net/en_US/all.js#xfbml=1",
			"http://platform.twitter.com/widgets.js",
			"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js",
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
	background-image:none;

}
</style>
<div style='text-align:center;'>
	<img alt='' border='0' src='/img/splash/ross/heading.jpg' />
</div>
<div style='width:728px; margin:auto;'>
	<?php 
	
	echo $this->element("dailyops/post-bit",array("dop"=>$post1));
	?>
	<div style='height:5px;'></div>
	<?php 
	echo $this->element("dailyops/post-bit",array("dop"=>$post2));
	
	?>
</div>
<div style='text-align:center;'>
	<a href='/dailyops'>
		<img alt='' border='0' src='/img/splash/ross/enter.jpg' />
	</a>	
</div>
<div style='height:200px;'></div>