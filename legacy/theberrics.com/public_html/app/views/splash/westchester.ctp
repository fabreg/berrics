<?php

$img_token = mt_rand(1,17);

$title_for_layout = "The Berrics - The Most Award Winning Skateboarding Site In The World";
$meta_d = "Inside Eric Koston & Steve Berra's Skatepark";
$this->set(compact("title_for_layout","meta_d"));

?>
<style>
body {

	background-color:#eceaea;

}
#creative {

	text-align:center;
	margin-top:80px;

}

#info-link {
	
	text-align:center;

}

#enter-berrics {

	text-align:center;
	font-size:22px;
	padding:20px;
}

#enter-berrics a {

	color:black;

}

#enter-berrics a:hover {

	color:Red;

}

</style>
<div id='creative'>
	<img src='/img/splash/westchester/<?php echo $img_token; ?>.jpg' />
</div>
<div id='info-link'>
	<a href='/skate_confirmation'>
		<img src='/img/splash/westchester/more-info.jpg' border='0' />
	</a>
</div>
<div id='enter-berrics'>
	<a href='/dailyops'>ENTER THE BERRICS</a>
</div>