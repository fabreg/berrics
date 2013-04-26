<?php 

$InstagramImageItem = ClassRegistry::init("InstagramImageItem");

$instagram = $InstagramImageItem->returnImagesByTagRaw("happybirthdayerickoston");


$this->set("body_element","layout/v3/one-column");


$this->set("title_for_layout","The Berrics - HAPPY BIRTHDAY ERIC!")


 ?>
<style>
body {

	background-image:url(/img/v3/koston-bday/bg.jpg);

}

#hb-koston {




}

#hb-koston .heading {

	text-align:center;

}
#hb-koston .hash {

	text-align: center;

}

#instagram {


	max-width:700px;
	margin:auto;
	text-align: center;

}
#instagram .instagram-image-item {

	
	padding:10px;
	background-image:url(/img/v3/layout/blk-px.png);
	color:#fff;
	margin-top:1%;

	width:100%;
}

#instagram .instagram-image-item .likes {


	letter-spacing: 2px;
	font-size:16px;
	padding-top:4px;
}

#instagram .instagram-image-item .likes a {


	color:#fff;

}

#hb-koston .dops-link {

	text-align:center;
	padding:8px;
	border:2px dotted #fff;
	border-left:none;
	border-right:none;
	
}

#hb-koston .dops-link a {

	font-family: 'Times New Roman';
	font-size: 26px;
	color:#fff;

}




/* Large desktop */
@media (min-width: 1200px) { 

	#instagram .instagram-image-item {

	
		float:left;
		width:47%;
		margin:1%;

	}

	#instagram .instagram-image-item:nth-child(even) {

		float:right;

	}


 }
 
/* Portrait tablet to landscape and desktop */
@media (min-width: 768px) and (max-width: 979px) { 


	#instagram .instagram-image-item {

	
		float:left;
		width:47%;
		margin:1%;

	}

	#instagram .instagram-image-item:nth-child(even) {

		float:right;

	}

 }
 
/* Landscape phone to portrait tablet */
@media (max-width: 767px) {  


	#instagram .instagram-image-item {

	
		float:left;
		width:47%;
		margin:1%;

	}

	#instagram .instagram-image-item:nth-child(even) {

		float:right;

	}

}
 
/* Landscape phones and down */
@media (max-width: 480px) {  }




</style>
<div id="hb-koston">
	<div class="heading">
		<a href="//instagram.com/erickoston" target='_blank'>
			<img src="/img/v3/koston-bday/hb-koston.png" alt="" border='0'>
		</a>
	</div>
	<div class='hash'>
		<a href="//instagram.com/erickoston" target='_blank'>
			<img src="/img/v3/koston-bday/hash-tag.png" alt="" border='0'>
		</a>
	</div>
	<div id='instagram' class='clearfix'>
			<?php foreach($instagram['data'] as $v): ?>
				<div class='instagram-image-item'>
					<img border='0' src='<?php echo $v['images']['low_resolution']['url']; ?>'/>
					<div class='likes'>
						<a href='//instagram.com/<?php echo $v['user']['username']; ?>' target='_blank'>@<?php echo $v['user']['username']; ?></a> <br />
						Likes: <?php echo $v['likes']['count']; ?>
					</div>
				</div>
			<?php endforeach; ?>
	</div>
	<div class="dops-link">
		<a href='/dailyops'>BACK TO THE DAILYOPS</a>
	</div>
</div>