<?php
		$this->Html->script(array(
		
			"http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js",
			"http://connect.facebook.net/en_US/all.js#xfbml=1",
			"http://platform.twitter.com/widgets.js",
			"http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js",
			"/js/jquery.scrollTo",
			"jquery.swfobject",
			"https://ajax.googleapis.com/ajax/libs/swfobject/2.2/swfobject.js",
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

</script>
<style>
body {

	background-color:#000;
	background-image:url(/img/splash/vans/bg.jpg);

}

.heading {

	text-align:center;
	height:183px;
	background-image:url(/img/splash/vans/bar.jpg);
	background-position:center bottom;
	background-repeat:repeat-x;
}
.vans-post {

	width:728px;
	margin:auto;

}
.vans-content {

	width:780px;
	margin:auto;
	
}
.dudes {

}

.dude {

	width:195px;
	float:left;
	height:480px;
}

.dude:nth-child(1) {
	
	background-image:url(/img/splash/vans/pfanner.jpg);

}
.dude:nth-child(2) {
	
	background-image:url(/img/splash/vans/crockett.jpg);

}
.dude:nth-child(3) {
	
	background-image:url(/img/splash/vans/chima.jpg);

}
.dude:nth-child(4) {
	
	background-image:url(/img/splash/vans/allen.jpg);

}

.d-post-bit .container-top,
.d-post-bit .container{

	background-image:none;

}

.d-post-bit .title {

	display:none;

}

.d-post-bit .footer,
.d-post-bit .bottom ,
.d-post-bit .html-content,
.d-post-bit hr {

	display:none;

}

.enter {

	text-align:center;
	font-size:28px;
	padding-bottom:70px;
}

.enter a {

	color:black;

}

.part {

text-align:center;
font-size:22px;
font-weight:bold;
color:#000;
font-family:'Arial';
}

</style>
<div>
	<div class='heading'>
		<img src='/img/splash/vans/header.jpg' border='0' /><br /><img src='/img/splash/vans/stage4.gif' border='0'/>
	</div>
	<div class='part'>PART 1</div>
	<div class='vans-post'>
		<?php 
			echo $this->element("/dailyops/post-bit",array("dop"=>$post));
		?>
	</div>
	<div class='vans-content'>
		<div style='text-align:center;'><img border='0' src='/img/splash/vans/names.jpg' /></div>
		<div class='dudes'>
			<div class='dude'></div>
			<div class='dude'></div>
			<div class='dude'></div>
			<div class='dude'></div>
			<div style='clear:both;'></div>
		</div>
		<div>
			<img src='/img/splash/vans/description.jpg' border='0'/>
		</div>
		<div>
			
		</div>

	</div>
	<div class='enter'>
	<img src='/img/splash/vans/line.jpg' border='0'/><br />
			<a href='/dailyops'>- ENTER THE BERRICS -</a>
	</div>
</div>