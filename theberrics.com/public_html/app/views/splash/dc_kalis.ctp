<?php
		echo $this->element("layout/html-head-scripts");
		$this->set("title_for_layout","DC - REDISCOVER HERITAGE");
?>
<script>

var swfPlayer = "/swf/BerricsPlayer.swf";

$(document).ready(function() { 



	setTimeout(function() { 

		$("#post,#enter").fadeIn("slow");

	},1500);

	
});

</script>
<style>
body {

	background-image:url(/img/splash/dc/kalis-bg.jpg);
	background-repeat:no-repeat;
	background-position:center top;
	background-color:#000;
	
}

#berricsVideo4fd25f0e-8654-4109-882a-38a4323849cf img {

	display:none;

}
#post {

	width:728px;
	margin:auto;
/*	background-image:url(/img/splash/girl/gc-px.png);*/
	display:none;
	padding-top:2px;
	text-align:center;
	margin-top:-22px;
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
	<div style='clear:both;'>
	<a href='http://www.dcshoes.com/us/en/skate?camp=da:dc_rediscoverheritage_theberrics' target='_blank'>
	<img src='/img/layout/clear.png' height='400' width='100%' border='0'/>
	</a>
	</div>

<div style='text-align:center;' id="enter">
<div><a href='/dailyops' style=''>- ENTER THE BERRICS -</a></div>
</div>
</div>
