<?php
		$this->Html->script(array(
		
			"http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js",
			"http://connect.facebook.net/en_US/all.js#xfbml=1",
			"http://platform.twitter.com/widgets.js",
			"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js",
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


	setTimeout(function() { 

		$("#post,#enter").fadeIn("slow");

	},2000);

	
});

</script>
<style>
body {

	background-image:url(/img/splash/girl/gc-bg.jpg);
	background-repeat:no-repeat;
	background-position:top center;
	
}
#post {

	width:728px;
	margin:auto;
	margin-top:200px;
	background-image:url(/img/splash/girl/gc-px.png);
	display:none;
}
#enter {

	text-align:center;
	display:none;

}

#enter a {

	color:#f0f0f0;
	font-size:22px;
	font-family:'Times New Roman';
}

.d-post-bit .container,.d-post-bit .container-top,.d-post-bit .bottom  {

	background-image:none;
	background-repeat:repeat;

}

.d-post-bit .container-top .title h2 {

	display:none;

}
</style>


<div id='gc-trailer'>
	
	<div id='post'>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
	<div style='clear:both; height:10px;'></div>
	<div id='enter'>
		<a href='/dailyops' title='The DailyOps'>- ENTER THE BERRICS -</a>
	</div>
</div>
