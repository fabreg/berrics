<?php 
		echo $this->Html->css(array(
			"v3/bootstrap",
			"v3/layout",
			"layout_override",
			"v3/bootstrap-responsive"
		),"stylesheet");

		echo $this->Html->script(array(
			"https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js",
			"v3/bootstrap",
			"v3/swfobject",
			"v3/modernizr",
			"v3/jquery.fullscreen-min",
			"v3/jquery.lazyload.min",
			"v3/jquery.swfobject",
			"v3/json2",
			"jquery.scrollTo",
			"v3/writeCapture",
			"https://connect.facebook.net/en_US/all.js#xfbml=1&appId=128870297181216",
			"https://platform.twitter.com/widgets.js",
			//"https://www.google.com/uds/api/ima/1.8/84479ae78e2ae96fc191dae83ffb2033/default.IN.js",
			"https://www.google.com/uds?file=ima&v=1&nodependencyload=true",
			"v3/video.div",
			"v3/videoPlayer",
			"v3/main"
		));
		/*


<script type="text/javascript" src="http://www.google.com/jsapi"></script>
<script type="text/javascript">
  //google.setOnLoadCallback(onSdkLoaded);
  google.load("ima", "1");

  function onSdkLoaded() {
    //var adsLoader = new google.ima.AdsLoader();
  }
</script>
 
		*/
 ?>
<!--[if IE]>
<script src="https://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
 <!--[if lt IE 9]>
<script src="/js/v3/respond.min.js"></script>
<![endif]-->