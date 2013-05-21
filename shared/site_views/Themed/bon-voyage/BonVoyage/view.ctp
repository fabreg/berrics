<?php

$this->set("title_for_layout","The Berrics - Bon Voyage : Joey Brezinski");

?>
<script>
	jQuery(document).ready(function($) {
				
		var meta = $("meta[name=viewport]");

		meta.attr({

			"content":"width=1300px, initial-scale=0"

		});

		$('.post-media-div').trigger('click');
	});
</script>
<div id="bon-voyage" >
	<div class="title-graphic">
		<img src="/theme/bon-voyage/img/heading.png" alt="">
	</div>
	<div id="post">
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
	<div class="bottom">
		<a href="https://itunes.apple.com/us/movie/bon-voyage-cliche-skateboards/id638487361" target='_blank'>
			<img src="/theme/bon-voyage/img/itunes.png" alt="" border='0'>
		</a>
	</div>
</div>
<div class="load-more">
	<a href="/2013/05/20">
		<img src="/theme/bon-voyage/img/load-more.jpg" alt="" border='0'>
	</a>
</div>