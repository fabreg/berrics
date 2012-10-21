<?php

$data = $pics;

$total_pics = count($data) - 1;

//get a random array

$seed = mt_rand(0,$total_pics);


$pic = $data[$seed];

$title_for_layout = "DC Shoes Presents: Battle At The Berrics 5";

$this->set(compact("title_for_layout"));



?>
<style>
* {

	padding:0px;
	margin:0px;

}

body {

	background-image:url(/img/splash/batb5/bg.jpg);
	font-family:'Arial';
	
}

.instagram {

	background-image:url(/img/splash/batb5-finals/finals-instagram-bg.jpg);
	height:371px;

}
.instagram .img {


	padding-top:13px;
	padding-left:13px;

}

.likes {

	font-style:italic;
	color:#999;
	text-indent:15px;
	font-size:14px;
	padding-top:5px;
}

.username {

	color:#999;
	font-weight:bold;
	text-indent:15px;
	font-size:16px;
}
</style>
<div style='width:332px; margin:auto;'>
	<div>
		<img src='/img/splash/batb5-finals/finals-heading.jpg' border='0' />
	</div>
	<div class='instagram'>
		<div class='img'>
			<img src='<?php echo $pic->images->low_resolution->url; ?>' border='0' alt='' />
		</div>
		<div class='info'>
			<div class='username'>
				@<?php echo $pic->user->username; ?>
			</div>
			<div class='likes'>
				Likes: <?php echo number_format($pic->likes->count);?>
			</div>
			
		</div>
	</div>
	<div>
		<a href='/'>
			<img border='0' src='/img/splash/batb5-finals/finals-refresh.jpg' />
		</a>
	</div>
</div>


