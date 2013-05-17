<style>

body {

	background-image:none;
	background-color:#000;

}

.wrapper {

	padding-top:35px;

}

.xgames {
	
	width:800px;
	border:2px solid #fff;
	margin:auto;

}

#post {

	max-width:728px;
	margin:auto;

}

#post .post .post-top,
#post .post .post-footer {

	display:none;

}

.heading,
.times {

	text-align: center;

}

#enter {

	text-align: center;
	font-size: 36px;
	font-family: 'universcnb';
	padding-top:40px;
}

#enter a {

	color:#fff;

}

</style>
<script>
	jQuery(document).ready(function($) {
		
		$('.post-media-div').trigger('click');

		handleVideoEnd = function() {

			document.location.href = "/dailyops";

		}

	});
</script>
<?php 

$this->set("title_for_layout","THE BERRICS - STREET LEAGUE XGAMES ");

$link = "http://xgames.espn.go.com/skateboarding/";

$img = "2-times.jpg";

$hr = date("G");

$min = date("i");

//time slot 2
if (($hr <=2) && ($min <= 29)) {
	
$link = "http://espn.go.com/watchespn/index/_/sport/#sport/extreme+sports/";

} 
 ?>
<div class="wrapper">
	<div class="xgames">
	<div class="heading">
		<a href="<?php echo $link; ?>">
			<img src="/img/v3/splash/xgames-es/top.jpg" alt="">
		</a>
	</div>
	<div id="post">
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
	<div class="times">
		<a href="<?php echo $link; ?>">
			<img src="/img/v3/splash/xgames-es/<?php echo $img; ?>" alt="">
		</a>
	</div>
</div>
</div>
<div id="enter">
	<a href="/dailyops">ENTER THE BERRICS</a>
</div>