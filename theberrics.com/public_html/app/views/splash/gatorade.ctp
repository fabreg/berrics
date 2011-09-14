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
<style type='text/css'>

body {

	background-color:black;
	background-image:url(/img/splash/gatorade/bg.jpg);
	background-repeat:no-repeat;
	background-position:center center;
}

.d-post-bit .text-content {

	display:none;

}
.d-post-bit .title h2 {

	display:none;

}
</style>
<div>
<div style='width:728px; margin:auto; padding-top:5px;'>
	<div style='text-align:center;'>
		<img src='/img/splash/gatorade/go-all.png' border='0'/>
	</div>
	<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>

</div>
<div style='text-align:center; padding-bottom:150px;'>
	<a href='/dailyops'>
		<img src='/img/splash/enter-the-berrics-large.jpg' border='0' />
	</a>
	<div style='padding-top:20px;'>
		Music By: Blue Foundation "Redhook" (Out soon on <a href="http://www.dpc-rec.dk/">DPC Records</a>)
	</div>
</div>

</div>
