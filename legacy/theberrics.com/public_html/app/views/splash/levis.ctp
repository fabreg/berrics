<?php
		
		echo $this->element("layout/html-head-scripts");

		$this->Html->css(array(
			"main",
			"layout",
			"layout_override",
			"vader/jquery-ui-1.8.11.custom"
		
		),"stylesheet",array("inline"=>false));
		$this->set("title_for_layout","The Berrics - LEVI'S 511 SKATEBOARDING COLLECTION");
?>
<script>

var swfPlayer = "/swf/BerricsPlayer.swf";

$(document).ready(function() { 

	$(body).css({'background-image':'none'});

	setTimeout(function() { 

		//$("#post,#enter").fadeIn("slow");

	},1500);

	
});

</script>
<style>
body {

	background-image:url(/img/splash/levis/bg.jpg);
	background-position:center top;
	background-color:#e9e9e9;
	
}

#berricsVideo4fd25f0e-8654-4109-882a-38a4323849cf img {

	display:none;

}
#post {

	width:728px;
	margin:auto;
/*	background-image:url(/img/splash/girl/gc-px.png);*/
	
	padding-top:2px;
	text-align:center;
	margin-top:22px;
	padding:2px;
	padding-bottom:15px;
	border:3px solid #000;
}
#enter {

	text-align:center;
	padding-top:5px;
	
}

#enter a {

	color:#fff;
	font-family:'Times New Roman';
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

.d-post-bit .container-top .title h2,.d-post-bit .sub-title,.d-post-bit .bottom {

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


</style>


<div id='gc-trailer'>

	<div id='post'>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
	<div style='clear:both;'>
	
	</div>

<div style='text-align:center;' id="enter">
<div style='padding-top:15px;'>
<a href='http://us.levi.com/shop/index.jsp?categoryId=13158492&cp=3146842.4305630' target="_blank">
<img src='/img/splash/levis/logos.png' border='0'/>
</a>
</div>
<div><a href='/dailyops' style=''>
<img border='0' src='/img/splash/levis/enter.png' />
</a></div>
</div>
</div>
