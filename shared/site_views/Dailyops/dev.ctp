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
	/*
	$.ajax({

		"url":"/dailyops/ajax_video_play",
		"success":function(d) {

			$("#autoplay").html(d);
			$("#autoplay video").click();
		}


	});
*/

});
</script>
<div class="row-fluid">
	<div class="span12">
		<?php foreach ($posts as $k => $v): ?>
			<div class="post">
				<h2><?php echo $v['Dailyop']['name']; ?></h2>
				<h4><?php echo $v['Dailyop']['sub_title']; ?></h4>
				<div class="dailyops-post" data-postid='<?php echo $v['Dailyop']['id']; ?>' data-media-file-id='<?php echo $v['DailyopMediaItem'][0]['MediaFile']['id'] ?>'>
					
				</div>
			</div>
		<?php endforeach ?>
	</div>
</div>
<div class="row-fluid">
	<div class="span8">
		LEFT COL
	</div>
	<div class="span4">
		RIGHT COL
	</div>
</div>
<div id="autoplay">
	
</div>