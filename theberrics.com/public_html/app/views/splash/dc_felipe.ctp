<?php
		
$part = (!isset($this->params['pass'][0])) ? 1:$this->params['pass'][0];

echo $this->element("layout/html-head-scripts");

$this->set("title_for_layout","The Berrics - DC: REDISCOVER HOME");

?>
<script>

var swfPlayer = "/swf/BerricsPlayer.swf";

$(document).ready(function() { 





	
});

</script>
<style>
body {

	background-image:url(/img/splash/dc-felipe/bg-<?php echo $part; ?>.jpg);
	background-repeat:no-repeat;
	background-position:center top;
	background-color:#fff;
	
}

#berricsVideo50569e14-2080-489c-b7f6-2514323849cf img,
#berricsVideo505fe55a-b658-4c20-ba30-0f00323849cf img {

	display:none;

}
#post {

	width:728px;
	margin:auto;
/*	background-image:url(/img/splash/girl/gc-px.png);*/

	padding-top:2px;
	text-align:center;
	margin-top:390px;
}
#enter {

	text-align:center;
	display:none;
	
}

#enter a {

	color:#fff;
	font-size:42px;
	font-family:'Times New Roman';
}

.d-post-bit {

	margin-bottom:0px;

}

.d-post-bit .container,.d-post-bit .container-top,.d-post-bit .bottom  {

	background-image:none;
	background-repeat:repeat;

}

.d-post-bit .container-top .display-media {

	margin:auto;

}

.d-post-bit .container-top .title h2,.d-post-bit .sub-title,.d-post-bit .bottom {

	display:none;

}

.date-info {

	display:none;

}

.d-post-bit .footer .tags {

	display:none;

}

.d-post-bit .container hr {

	display:none;

}


</style>


<div id='gc-trailer'>

	<div id='post'>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>

<div style='text-align:center;'>
<div><a href='/dailyops' style=''><img border='0' src='/img/splash/dc-felipe/link.jpg' /></a></div>
</div>
</div>
