<?php 
		echo $this->Html->css(array(
			"v3/bootstrap",
			"v3/layout",
			"v3/bootstrap-responsive"
		),"stylesheet");

		echo $this->Html->script(array(
			"https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js",
			"v3/bootstrap",
			"v3/modernizr",
			"v3/jquery.fullscreen-min",
			"v3/respond.min.js",
			"v3/html5shiv",
			"https://www.google.com/uds/api/ima/1.8/84479ae78e2ae96fc191dae83ffb2033/default.IN.js",
			//"https://www.google.com/uds?file=ima&v=1&nodependencyload=true",
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
