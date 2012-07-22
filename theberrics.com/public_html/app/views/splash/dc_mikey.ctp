<?php
		
		echo $this->element("layout/html-head-scripts");

		$this->set("title_for_layout","The Berrics - DC REDISCOVER");
?>
<script>

var swfPlayer = "/swf/BerricsPlayer.swf";

$(document).ready(function() { 



	setTimeout(function() { 

		$("#post,#enter").fadeIn("slow");

	},1000);

	
});



</script>
<style>
body {

		background: none;
		background-color:#000;
		
}

#berricsVideo500a1f50-f2ec-4901-84bc-4060323849cf img {

	display:none;

}
#post {

	width:728px;
	margin:auto;
/*	background-image:url(/img/splash/girl/gc-px.png);*/
	display:none;
	padding-top:2px;
	text-align:center;
}
#enter {

	text-align:center;
	display:none;
	padding-bottom:85px;
}

#enter a {

	color:#999;
	font-size:32px;
	font-family:'Arial';
	font-weight:normal;
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

.d-post-bit .container-top .title h2,.d-post-bit .sub-title {

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

.d-post-bit .buttons {

	width:210px;
	margin:auto;
	display:none;

}
#mikey {

	background-image:urL(/img/splash/dc-mikey/top.jpg);
	height:650px;
	width:1000px;
}

#page {

	width:1000px;
	margin:auto;

}

</style>


<div id='page'>
	<div id='mikey'>
		<div id='shim'></div>
		<div id='post'>
			<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
		</div>
		<div style='clear:both;'>
	
		</div>
	</div>
<div style='text-align:center;'>
	<a href='http://store.dcshoes.com/product/index.jsp?productId=12624374&cp=4030634' target='_blank'>
		<img src='/img/splash/dc-mikey/logo.jpg' border='0'/>
	</a>
</div>
<div style='text-align:center;' id="enter">
<div><a href='/dailyops' style=''><img border='0' src='/img/splash/dc-mikey/enter.jpg'/></a></div>
</div>
</div>
