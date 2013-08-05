<style>

body {

	background-image:url(/img/v3/splash/skate-lite/bg.jpg);
	background-size:cover;
	background-attachment: fixed;
	background-position: left bottom;

}

#wrapper {

	width:800px;
	margin:auto;
	position: relative;
	height:100%;
	min-height:800px;
}

#heading {

	

}

#post {

	width:728px;
	margin:auto;

}

#post .post {

	border:none;

}

#post .post .post-top,
#post .post .post-footer,
#post .post .post-media-div img {

	display: none;

}

#post .post-media-div,
#post video {

	height:400px;

}

#link {

	text-align:right;

}

#enter {

	text-align:right;

}

#bottom {

	position: absolute;
	bottom:5px;
	width:100%;
	height:auto;
	padding-bottom:30px;

}

</style>
<div id="wrapper">
	<div id="heading">
		<img src="/img/v3/splash/skate-lite/heading.png" alt="">
	</div>
	<div id="post">
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post,"lazy"=>false)) ?>
	</div>
	<div id="bottom">
		<div id="link">
			<a href="http://skatelite.com/the-retreat/" target='_blank'>
				<img src="/img/v3/splash/skate-lite/link.png" alt="">
			</a>
		</div>
		<div id="enter">
			<a href="/dailyops">
				<img src="/img/v3/splash/skate-lite/enter.png" alt="">
			</a>
		</div>
	</div>
</div>