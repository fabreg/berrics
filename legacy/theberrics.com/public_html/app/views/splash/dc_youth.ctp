<?php 

echo $this->element("layout/html-head-scripts");

$this->set("title_for_layout","The Berrics - DC Youth Division");

?>
<style>

body {

	background-image:url(/img/splash/dc-youth/bg.jpg);
	background-position: top center;
	background-repeat: no-repeat;
	background-color: #fff;

}

#post {

width:730px;
margin:auto;
padding-top: 80px;
}


#post .d-post-bit .display-media img {


	display: none;

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
</div>
<div class='enter'>
<a href='/dailyops'>
	<img border='0' src='/img/splash/dc-youth/enter.png' />
</a>
</div>