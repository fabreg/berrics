<style type="text/css">
.dailyops-post {

	min-height:250px;
	background-color: #e9e9e9;

}
</style>
<script type="text/javascript">
jQuery(document).ready(function($) {
	
	$('.dailyops-post').click(function(e) { 

		$(this).videoDiv();
		$(this).unbind('click');

	});

});
</script>
<div class="row-fluid">
	<div class="span12">
		<?php foreach ($posts as $k => $v): ?>
			<div class="post">
				<h2><?php echo $v['Dailyop']['name']; ?></h2>
				<div class="dailyops-post" data-postid='<?php echo $v['Dailyop']['id']; ?>' data-media-file-id='<?php echo $v['DailyopMediaItem'][0]['MediaFile']['id'] ?>'>
					
				</div>
			</div>
		<?php endforeach ?>
		<div class="post">
			<video width='100%' poster='http://img.theberrics.com/video/stills/a8e40b84c360c50c267a72308987b2e1.jpg' controls='true' preload='0' >
				<!--
				<source id="mp4" src="http://berrics.vo.llnwd.net/o45/5091c414-f1d0-4fd6-a56c-1d28c6659e49.mp4" type="video/mp4">
				-->
			</video>
		</div>
	</div>
</div>
<div class="row-fluid">
	<div class="span8">
		
	</div>
	<div class="span4">
		RIGHT COL
	</div>
</div>