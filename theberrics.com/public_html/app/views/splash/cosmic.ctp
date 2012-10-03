<?php 

echo $this->element("layout/html-head-scripts");

$this->set("title_for_layout","The Berrics - Cosmic Vomit");

?>
<style>

body {

	background-image:url(/img/splash/cosmic/bg.jpg);

}

#post {

width:730px;
margin:auto;

}

#post .d-post-bit .display-media {

background-image:url(/img/splash/cosmic/video-bg.jpg);
padding:12px;
margin:auto;

}




.d-post-bit .container,
.d-post-bit .container-top,
.d-post-bit .bottom {

background-image:none;

}

.d-post-bit .title,
.d-post-bit .bottom,
.d-post-bit hr,
.d-post-bit .text-content {

display:none;

}

.enter {
padding-top:10px;
text-align:center;

}


</style>
<div id='post'>
	<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	<div>
		<img src='/img/splash/cosmic/text.jpg' border='0' />
	</div>
</div>
<div class='enter'>
<a href='/dailyops'>
	<img border='0' src='/img/splash/cosmic/enter.png' />
</a>
</div>