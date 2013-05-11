<?php 

$this->layout = "splash";


 ?>
 <style>

body {

	background-image:url(/img/v3/splash/vans-protec/bg.jpg);
	background-repeat: no-repeat;
	background-size:cover;
	-ms-background-size:cover;
	-webkit-background-size:cover;
	-moz-background-size:cover;
	-o-background-size:cover;
	background-position: center top;
	min-height:700px;
}

.top-logo {

	text-align: center;

}

.text {

	text-align: center;

}

#enter {

	text-align: center;
	font-size:28px;
	background-color:#000;
	padding:10px;
	padding-bottom:20px;
	position: absolute;
	bottom:0px;
	left:0px;
	width:100%;
}

#enter a {

	color:#fff;
	font-family: 'universcnb';
}

#post {

	width:728px;
	margin:auto;
	border:none;
}

#post .post {

border:none;

}

#post .post .post-top,
#post .post .post-footer,
#post .post .post-media-div img {

	display:none;

}

 </style>
 <div id="vans">
 	<div class="top-logo">
 		<img src="/img/v3/splash/vans-protec/heading.png" alt="">
 	</div>
 	<div class="text">
 	<a href="http://www.vans.com/eventsites/pool2013/?utm_source=berrics&utm_medium=300pool&utm_content=poolparty&utm_campaign=poolparty13" target='_blank'>
 	<?php if ((date("G")>9 && date("i")>30) && (date("G")<19 && date("i")<15)): ?>
 		<img src="/img/v3/splash/vans-protec/live.png" border='0' alt="">
 	<?php else: ?>
 		<img src="/img/v3/splash/vans-protec/pending.png" border='0' alt="">
 	<?php endif ?> 	
 	</a>	
 	</div>
 	<div id="post">
 		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post),1); ?>
 	</div>
	<div id="enter">
		<a href="/dailyops">ENTER THE BERRICS</a>
	</div>
 </div>