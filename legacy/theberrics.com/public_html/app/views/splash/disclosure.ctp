<?php
		
		echo $this->element("layout/html-head-scripts");

		$this->set("title_for_layout","The Berrics - Disclosure");
?>

<style>
body {

		background: url(/img/splash/disclosure/bg.jpg) no-repeat center top fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
		background-color:#000;
		
}

.display-media img {

	display:none;

}
#post {
	margin-top:35px;
	width:728px;
	margin:auto;
/*	background-image:url(/img/splash/girl/gc-px.png);*/
	
	padding-top:2px;
	text-align:center;
	background-image:url(/img/splash/disclosure/logo.png);
	background-repeat:no-repeat;
	background-position:center center;
}
#enter {

	text-align:center;

	
}

#enter a {

	color:#999;
	font-size:32px;
	font-family:'Arial';
	font-weight:normal;
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

}

.d-post-bit .container-top .title h2,.d-post-bit .sub-title,.d-post-bit .bottom,.d-post-bit .text-content {

	display:none;

}

.date-info {

	display:none;

}

.d-post-bit .footer .tags {

	display:none;

}

.d-post-bit .container hr {

	display:none;

}

.d-post-bit .buttons {

	width:210px;
	margin:auto;

}


</style>


<div id='gc-trailer'>

	<div id='post'>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
	<div style='clear:both; height:30px;'>

	</div>

<div style='text-align:center;' id="enter">
	<a href='/dailyops'>
		<img src='/img/splash/disclosure/enter.png' border='0' />
	</a>
</div>
</div>
