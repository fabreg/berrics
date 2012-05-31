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


	$("div[media_file_id]").unbind('click').click(function() { 

		var data = eval("("+$("div[media_file_id]").attr("media_file")+")");

		//alert(data);
		
		berricsPlayer("berricsVideo"+data['MediaFile']['id'],data,532,400);

	}).css({

		width:"532px",
		height:"400px"

	}).find(".overlay").css({

		width:"532px",
		height:"400px"

	}).parent().find('.play-button').css({
		'left':'205px'
	});

	
});

</script>
<style>
body {

	background-image:url(/img/splash/almost/almost-bg.jpg);
	background-color:white;
	
}
#post {

	width:800px;
	margin:auto;
	padding-top:21px;
	text-align:center;
}
#enter {

	text-align:center;
	padding-top:15px;

}

#enter a {

	color:#f0f0f0;
	font-size:28px;
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
	width:534px;
	padding-left:80px;
}

.d-post-bit .container-top .title h2,
.d-post-bit .sub-title,
.d-post-bit .container hr,
.d-post-bit .bottom .tags {

	display:none;

}

.d-post-bit .dailyop_media_item {



}

.date-info {

	display:none;

}

.post-container {

	width:800px;
	height:540px;
	background-image:url(/img/splash/almost/almost-mid.png);
	margin:auto;
}

</style>


<div id='gc-trailer'>
	<div style='text-align:center;'>
		<img src='/img/splash/almost/almost-top.jpg' border='0'/>
	</div>
	<div style='text-align:center;' class='post-container'>
		<div id='post'>
			<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
		</div>
	</div>
	<div style='text-align:center;'>
		<a href='http://almostawebsite.com' target='_blank'><img src='/img/splash/almost/almost-bot.png' border='0'/></a>
	</div>

	<div style='clear:both; height:10px;'></div>

<div style='text-align:center;' id="enter">
<div><a href='/dailyops' style='color:black;'>- ENTER THE BERRICS -</a></div>
</div>
</div>
