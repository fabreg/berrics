<?php
		$this->Html->script(array(
		
			"http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js",
			"http://connect.facebook.net/en_US/all.js#xfbml=1",
			"http://platform.twitter.com/widgets.js",
			"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js",
			"/js/jquery.scrollTo",
		"https://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js",
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
	background-position:center center;
	background-image:url(/img/splash/bang-me/bg.jpg);

}

#bang-yoself-3 .d-post-bit,#bang-yoself-3 .d-post-bit .container-top {

	background-color:#000;
	
}

#bang-yoself-3 .d-post-bit .display-media {


}

#bang-yoself-3 .d-post-bit h2 {

	

}

#bang-yoself-3 .d-post-bit .sub-title {

	

}

#bang-yoself-3 .d-post-bit .container, 
#bang-yoself-3 .d-post-bit .container-top,
#bang-yoself-3 .d-post-bit .bottom {

	background-image:none;

}

#bang-yoself-3 .d-post-bit .title {

	margin-top:7px;

}

</style>
<div>
	<div style='text-align:center;'>
		<img src='/img/splash/bang-me/heading.png'/><br />
		<img src='/img/splash/bang-me/<?php echo $dude; ?>-heading.png'/>
		
	</div>
	<div style='width:728px; margin:auto;' id='bang-yoself-3'>
		
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
		<div style='height:10px;'></div>
		<div style='text-align:center;'>
			<a href='/dailyops'>
				<img alt='' border='0' src='/img/splash/bang-me/enter.png' />
			</a>
		</div>
	</div>
</div>