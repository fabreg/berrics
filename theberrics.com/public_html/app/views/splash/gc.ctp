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

	background-image:url(/img/splash/girl/gc-bg.jpg);
	background-repeat:no-repeat;
	background-position:top center;
	
}
#post {

	width:728px;
	margin:auto;
	margin-top:230px;
	background-image:url(/img/splash/girl/gc-px.png);
}

.d-post-bit .container,.d-post-bit .container-top,.d-post-bit .bottom  {

	background-image:none;
	background-repeat:repeat;

}
</style>


<div id='gc-trailer'>
	<div></div>
	<div id='post'>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
	<div style='clear:both;'></div>
</div>
