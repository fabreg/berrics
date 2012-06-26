<?php
		
		echo $this->element("layout/html-head-scripts");

		$this->set("title_for_layout","The Berrics - QUIK");
?>
<script>

var swfPlayer = "/swf/BerricsPlayer.swf";

$(document).ready(function() { 



	setTimeout(function() { 

		$("#post,#enter").fadeIn("slow");

	},1500);


	posPost();

	$(window).resize(function() { 

		posPost();

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

		background: url(/img/splash/quik/bg.jpg) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
		background-color:#ccc;
		
}

#berricsVideo4fe4cfc1-fb44-4ecb-bf05-09a7323849cf img {

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
	padding-top:85px;
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
	<div id='shim'></div>
	<div id='post'>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
	<div style='clear:both;'>

	</div>

<div style='text-align:center;' id="enter">
<div><a href='/dailyops' style=''><img border='0' src='/img/splash/quik/enter-link.png'/></a></div>
</div>
</div>
