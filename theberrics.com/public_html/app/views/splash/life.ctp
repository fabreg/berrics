<?php 

echo $this->element("layout/html-head-scripts");

$this->set("title_for_layout","The Berrics - Life: Featuring Paul Rodriguez");

?>
<style>

body {

	background:url(/img/splash/life/bg1.jpg) no-repeat center top fixed;
        -webkit-background-size: cover;
        -moz-background-size: cover;
        -o-background-size: cover;
        background-size: cover;
	background-color:#000;

}

#post {

width:730px;
margin:auto;
padding-top: 55px;
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

#post-bg {

	background-image:url(/img/splash/life/top.png);
	background-repeat: no-repeat;
	background-position: center 70px;
	min-height:328px;

}

</style>
<div id="post-bg">
	<div id='post'>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
</div>
<div class='enter'>
<a href='/dailyops'>
	<img border='0' src='/img/splash/life/enter.png' />
</a>
</div>