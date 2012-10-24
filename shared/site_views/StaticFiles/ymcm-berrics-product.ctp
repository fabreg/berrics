<?php

//title for the page
$title_for_layout = "YMCM - The Berrics";

//layout file
///un-comment the line below to use a blank layout template;
$this->layout = "blank";

//meta keywords
$meta_k = '';

//meta description
$meta_d = '';

$this->set(compact("title_for_layout","meta_k","meta_d"));


?>
<html>
	<head>
	<title>YMCM - BERRICS</title>
<style>
* {

margin:0px;
padding:0px;

}
body {

background-color:white;
background-image:url(/img/splash/ymcm-berrics/bg.jpg);

}
.main-container {

background-image:url(/img/splash/ymcm-berrics/top-bg.jpg);
background-repeat:repeat-x;

}
</style>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=128870297181216";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<div class='main-container'>
	<div style='width:1000px; margin:auto;'>
		<div>
			<a href='/dailyops'>
				<img border='0' src='/img/splash/ymcm-berrics/1.png' />
			</a>
		</div>
		<div>
			<a href='/dailyops'>
				<img border='0' src='/img/splash/ymcm-berrics/enter.png' />
			</a>
		</div>
		<div style='width:470px; margin:auto;'>
		<div class="fb-comments" data-href="http://theberrics.com/ymcm-berrics-product.html" data-num-posts="20" data-width="470"></div>
		</div>
	</div>
</div>
</body>
</html>