<div id="post-section">
	<div class="row-fluid">
		<div class="span12">
			<div class="banner-728" id='banner1'>
				<img src="/img/v3/layout/728-banner.png" alt="" border='0'>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<?php foreach ($posts as $k => $v): ?>
			<div class='standard-post-thumb'>
			<?php 

				$media_file = $v['DailyopMediaItem'][0]['MediaFile'];
				echo $this->Media->mediaThumb(array(
					"MediaFile"=>$media_file,
					"w"=>300
				));
			?>
			</div>
		<?php endforeach ?>
	</div>
</div>