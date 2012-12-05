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
			"v3/modernizr",
			"v3/jquery.fullscreen-min",
			"v3/respond.min.js",
			"v3/jquery.lazyload.min",
			"v3/html5shiv",
			"jquery.scrollTo",
			//"v3/jquery.writeCapture",
			"https://connect.facebook.net/en_US/all.js#xfbml=1&appId=128870297181216",
			"https://platform.twitter.com/widgets.js",
			//"https://www.google.com/uds/api/ima/1.8/84479ae78e2ae96fc191dae83ffb2033/default.IN.js",
			"https://www.google.com/uds?file=ima&v=1&nodependencyload=true",
			"v3/video.div",
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
<script type='text/javascript'>
var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
var gads = document.createElement('script');
gads.async = true;
gads.type = 'text/javascript';
var useSSL = 'https:' == document.location.protocol;
gads.src = (useSSL ? 'https:' : 'http:') + 
'//www.googletagservices.com/tag/js/gpt.js';
var node = document.getElementsByTagName('script')[0];
node.parentNode.insertBefore(gads, node);
})();
</script>

