<?php 

$this->set("title_for_layout","The Berrics - JIM GRECO - DEATHWISH VIDEO");

 ?>
<script>
jQuery(document).ready(function($) {
	
		var meta = $("meta[name=viewport]");

		meta.attr({

			"content":"width=1000px, initial-scale=0"

		});

		$("#post .post-media-div").trigger('click');
		// /theme/progression/img/wide-still.jpg

});
</script>
<div id="deathwish-video">
	<div class="logo">
		<img src="/theme/deathwish-video/img/logoage.png" alt="">
	</div>
	<div id="post">
		<div class="post-inner">
			<?php echo $this->element('dailyops/post-bit',array('dop'=>$post,"lazy"=>true)); ?>
		</div>
	</div>
	<div class="text-content">
		<p>
To celebrate the release of the new Deathwish video, Jim Greco has decided to gift all of you his part, and his part only, exclusively on the Berrics for a day. There will be no other parts fallin from the sky. If you wanna see Moose and Ellington and Furby and the rest of the crew, which you're gonna wanna see after you see this part, you gotta take your ass to <a href='https://itunes.apple.com/us/movie/deathwish-video-deathwish/id635160589' target='_blank'>iTunes</a> and give make a purchase. Share with your friends, your enemies, your friends friends and their enemies this part right here becuase everyone should see this because it truly is one of the best parts of the year. - sb 
		</p>
	</div>
	<div class="jim">
		<img src="/theme/deathwish-video/img/greco.png" alt="">
	</div>
	<div class="top">
		<img src="/theme/deathwish-video/img/top.png" alt="" />
	</div>
	<div class="itunes">
		<a href='https://itunes.apple.com/us/movie/deathwish-video-deathwish/id635160589' target='_blank'>
			<img src="/theme/deathwish-video/img/itunes.jpg" alt="" border='0' />
		</a>
	</div>
	<div class="load-more">
		<a href="/2013/04/29">
			<img src="/theme/deathwish-video/img/load-more.png" border='0' alt="">
		</a>
	</div>
</div>