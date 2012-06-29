<?php
		
		echo $this->element("layout/html-head-scripts");

		$this->set("title_for_layout","The Berrics - Converse Presents The KA One Vulc");
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

		background: url(/img/splash/cons/cons-kenny-bg.jpg) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
		background-color:#fff;
		height:100%;
		
}

#berricsVideo4fec9138-49d8-42c4-ae32-604f323849cf img {

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
	position:absolute;
	bottom:5px;
	width:100%;
}

#enter a {

	color:#000;
	font-size:32px;
	font-family:'Arial';
	font-weight:normal;
	text-decoration:none;
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

	display:none;

}


</style>


<div id='gc-trailer'>
	<div id='shim'></div>
	<div id='post'>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
	<div style='padding:5px; text-align:center;'>
			<a href='http://www.converse.com/skateboarding' target='_blank'>
				<img border='0' src='/img/splash/cons/converse-splash-logo.png' alt='Converse'/>
			</a>
		</div>
	<div style='clear:both;'>

	</div>

<div style='text-align:center;' id="enter">
<div><a href='/dailyops' style=''>-ENTER THE BERRICS-</a></div>
</div>
</div>
