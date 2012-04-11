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
?>
<script>

var swfPlayer = "/swf/BerricsPlayer.swf";

$(document).ready(function() { 




	
});

</script>
<style>

body {

	background-image:url(/img/splash/yn3/final-bg.jpg);

}

.yn3 {

	text-align:center;

}

.post {

	width:728px;
	margin:auto;

}


.d-post-bit {

	margin-bottom:0px;
	margin-top:0px;
}

.d-post-bit .container,.d-post-bit .container-top,.d-post-bit .bottom  {

	background-image:none;
	background-repeat:repeat;

}

.d-post-bit .container-top .display-media {

	margin:auto;

}

.d-post-bit .container-top .title h2,.d-post-bit .sub-title,.d-post-bit .text-content {

	display:none;

}

.date-info {

	display:none;

}
.d-post-bit .container hr {

	display:none;

}

.d-post-bit .bottom {

	display:none;
} 

.d-post-bit .tags {

	display:none;

}

</style>
<div class='yn3'>
	<div style='padding-top'>
		<img src='/img/splash/yn3/yn3-finalist-header.png' border='0' />
	</div>
	<div class='post'>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
	<div class='enter'>
		<a href='/dailyops'>
			<img src='/img/splash/yn3/final-enter.png' border='0' />
		</a>	
	</div>
</div>