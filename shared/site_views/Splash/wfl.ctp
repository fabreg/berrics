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

$(document).ready(function() { 




	
});

</script>
<style>
* {

	margin:0px;
	padding:0px;

}
body {

	background-color:#000;
	background-image:url(/img/splash/wfl/dway.jpg);
	background-repeat:no-repeat;
	background-position:top center;
}

.dway {

	text-align:center;


	min-height:562px;

}

.connect {

	font-size:24px;
	font-weight:bold;
	font-family:'Arial';
	
}

.connect a {

	color:white;

}
.enter {

	padding-top:75px;

}


#post {

	width:728px;
	margin:auto;
	margin-top:-7px;
	
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

.d-post-bit .container-top .title h2,.d-post-bit .sub-title {

	display:none;

}

.date-info {

	display:none;

}
.d-post-bit .container hr {

	display:none;

}

.d-post-bit .footer {

	display:none;
} 

.d-post-bit .tags {

	display:none;

}
</style>
<!-- 
 && $_SERVER['GEOIP_REGION_NAME']=='california'
 -->
<div class='dway'>
	<div id='post'>
		<div style=''></div>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>

	<div class='enter'>
		<?php if(
		$_SERVER['GEOIP_COUNTRY_CODE']=="US" && strtolower($_SERVER['GEOIP_REGION_NAME'])=='california'
	): ?>
	<div class='connect'>
		<a href='/identity/login/send_to_facebook/<?php echo base64_encode("/wfl"); ?>'>Click Here To Connect With Facebook To Win Tickets!</a>
	</div>
	<?php endif; ?>
		<a href='/dailyops'>
			<img src='/img/splash/wfl/enter.jpg' border='0'/>
		</a>
	</div>
</div>