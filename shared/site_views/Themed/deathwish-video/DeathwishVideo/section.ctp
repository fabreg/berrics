<?php 

$this->set("title_for_layout","The Berrics - JIM GRECO - DEATHWISH VIDEO");

 ?>
<script>
jQuery(document).ready(function($) {
	
		var meta = $("meta[name=viewport]");

		meta.attr({

			"content":"width=900px, initial-scale=0"

		});

		$("#post .post-media-div").trigger('click');
		// /theme/progression/img/wide-still.jpg

});
</script>
<div id="deathwish-video">
	<div class="top">
		<img src="/theme/deathwish-video/img/top.png" alt="" />
	</div>
	<div id="post">
		<div class="post-inner">
			<?php echo $this->element('dailyops/post-bit',array('dop'=>$post,"lazy"=>true)); ?>
		</div>
	</div>
	<div class="logo">
		<img src="/theme/deathwish-video/img/video-logo.png" alt="">
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