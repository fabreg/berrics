<?php
		
		echo $this->element("layout/html-head-scripts");

		$this->set("title_for_layout","The Berrics - NIKE SB: PAUL RODRIGUEZ VI");
?>
<script>

var swfPlayer = "/swf/BerricsPlayer.swf";

$(document).ready(function() { 



	setTimeout(function() { 

		$("#post,#enter").fadeIn("slow");

	},1500);


	//posPost();

	$(window).resize(function() { 

		//posPost();

	});
	
});

function posPost() {

	var ph = $("#post").height();
	var bh = $(window).height();

	var padding = (bh/2) - (ph/2);
	
	$("#shim").css({

		"height":padding+"px"
			
	});
	
}

</script>
<style>
body {

		background:#cc9966 url(/img/splash/nike-prod/bg.jpg) no-repeat center top;
		background-size:cover;
		
}

#berricsVideo50119444-6130-48f5-a485-6a22323849cf img {

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

}


</style>


<div id='gc-trailer'>
	<div id='shim' style='padding-bottom:0px; text-align:center;'>
		<img border='0' src='/img/splash/nike-prod/prod-logo.png'/>
	</div>
	<div id='post'>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
	<div style='clear:both;'>

	</div>

<div style='text-align:center;' id="enter">
<div>
	<a href='http://clk.atdmt.com/AVE/go/407242974/direct/01/' target='_blank'>
		<img border='0' src='/img/splash/nike-prod/shoe.png' />
	</a>
</div>

<div><a href='/dailyops' style=''><img border='0' src='/img/splash/nike-prod/enter.png'/></a></div>
</div>
</div>
<img src='http://view.atdmt.com/AVE/view/407242974/direct/01/' width='1' height='1' border='0'/>