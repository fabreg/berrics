<script>
	jQuery(document).ready(function($) {
		

		var meta = $("meta[name=viewport]");

		meta.attr({

			"content":"width=950px, initial-scale=0"

		});

		$("#post .post-media-div").trigger('click');
		// /theme/progression/img/wide-still.jpg


		$("#post .post-media-div img.swf").attr({
			src:"/theme/progression/img/wide-still.jpg"
		});

	});
</script>
<?php if (isset($this->request->params['splash_page'])): ?>
<style>
	
	header {

		display:none;

	}


</style>
<?php endif ?>
<div id="progression-lander">
	<div id="heading">
		<div>
			<img src="/theme/progression/img/heading.png" alt="">
		</div>
		<div>
			<img src="/theme/progression/img/line.png" alt="">
		</div>
	</div>
	<div id="post">
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
	<div id="sig">
		<img src="/theme/progression/img/sig.png" alt="">
	</div>
	<?php if (isset($this->request->params['splash_page'])): ?>
	<div id="load-more">
		<a style='font-size:36px; color:#fff;' href='/dailyops'>ENTER THE BERRICS</a>
	</div>
	<?php else: ?>
	<div id="load-more">
		<a href='/2013/04/05'><img src="/theme/progression/img/load-more.png" alt="" border='0'></a>
	</div>
	<?php endif ?>
	
</div>