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
<?php 

$bg = "1";

$bg = mt_rand(1,3);

$bg = $bg.".jpg";

?>
<style>
body {

		background: url(/img/splash/hesh/<?php echo $bg; ?>) no-repeat center center fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
		background-color:#000;
		
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

.d-post-bit .buttons {

	width:210px;
	margin:auto;

}


</style>


<div id='gc-trailer'>
	<div style='text-align:center;'>
		<img src='/img/splash/hesh/top.png' border='0' />
	</div>
	<div id='post'>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
	<div style='clear:both;'>

	</div>

<div style='text-align:center;' id="enter">
<div><a href='/dailyops' style=''><img border='0' src='/img/splash/hesh/hesh.png'/></a></div>
<div><a href='/dailyops' style=''><img border='0' src='/img/splash/hesh/enter.png'/></a></div>
</div>
</div>
