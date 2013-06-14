<?php 

$this->set("body_element","layout/v3/one-column");

$this->set("title_for_layout","THE BERRICS - MARK APPLEYARD SOUL REBEL");

$Dailyop = ClassRegistry::init("Dailyop");

$post = $Dailyop->returnPost(array(
			"Dailyop.id"=>7191
		),1);

?>
<script>
	jQuery(document).ready(function($) {
			
					var meta = $("meta[name=viewport]");

		meta.attr({

			"content":"width=1100px, initial-scale=0"

		});

		$("#post .post-media-div").trigger('click');


	});
</script>
<style>

#soul-rebel {

	margin-top:-20px;

}

#main-container {

	
	width:100%;
	min-width:1100px;


}

#video {

	position:relative;
	background-image:url(/img/v3/soul-rebel/top-bg.jpg);
	background-repeat: no-repeat;
	background-position:top right;
	height:610px;
}

#video .left-bar {

	height:100%;
	position: absolute;
	left:0px;
	top:0px;
	width:175px;


}

#video .movie-type {

	text-align:center;
	margin-top:-20px;
}


#post .post .post-media-div {

	min-height:400px;

}

#post .post .post-media-div img {

	display:none;

}

#post {


	width:700px;
	margin:auto;
	padding-top:20px;

}

#post .post  {

	border:none;

}

#post .post .post-top,
#post .post .tags,
#post .post .text-content {

	display:none;

}

#white-bar {

	margin-top:-8px;
	height:83px;
	background-image:url(/img/v3/soul-rebel/white-bar-bg.png);
	text-align: center;
}

#white-bar img {

	margin-top:10px;

}

#deck {

	margin-top:3px;
	text-align: center;
	padding-top:20px;
	padding-bottom:20px;
	background-image:url(/img/v3/soul-rebel/deck-bg.jpg);

}

#interogated {

margin-top:5px;

-moz-box-shadow: 0 0 5px 5px #888;
-webkit-box-shadow: 0 0 5px 5px#888;
box-shadow: 0 0 5px 5px #888;
text-align: center;
background-image:url(/img/v3/soul-rebel/interogated-bg.jpg);
height:722px;
background-position: center center;
}

#load-more {
	
	background-image:url(/img/v3/soul-rebel/load-bg.jpg);
	

}

#load-more .left-cap {

	float:left;
	width:53px;
}

#load-more .right-cap {

	float:right;
	width:49px;
}

#load-more .center {

	text-align: center;
	margin-left:53px;
	margin-right:49px;
}


</style>
<div id='soul-rebel'>
	<div id="video">
		<div class="left-bar">
			<img src="/img/v3/soul-rebel/top-left.jpg" alt="">
		</div>
		<div id="post">
			<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)) ?>
		</div>
		<div class="movie-type">
			<img src="/img/v3/soul-rebel/movie-type.png" alt="">
		</div>
	</div>
	<div id="white-bar">
		<img src="/img/v3/soul-rebel/white-bar.jpg" alt="">
	</div>
	<div id="deck">
		<a href="">
			<img src="/img/v3/soul-rebel/deck.png" border='0' alt="">
		</a>
	</div>
	<div id="interogated">
		<a href="/interrogation/mark-appleyard">
		<img src="/img/v3/layout/px.png" height='720' width='1100' alt="">
		</a>
	</div>
	<div id="load-more">
		<div class="left-cap">
			<img src="/img/v3/soul-rebel/load-left.jpg" alt="">
		</div>
		<div class="right-cap">
			<img src="/img/v3/soul-rebel/load-right.jpg" alt="">
		</div>
		<div class="center">
			<a href="/2013/06/14">
				<img src="/img/v3/soul-rebel/load-more.jpg" alt="">
			</a>
		</div>
	</div>
</div>