<div class='post-thumb standard-post-thumb'>
<?php 

	$media_file = $post['DailyopMediaItem'][0]['MediaFile'];
	$thumb_url = $this->Media->mediaThumbSrc(array(
						"MediaFile"=>$media_file,
						"w"=>300
					));
?>
	<div class="post-date">
		<?php echo date("m.d.Y",strtotime($post['Dailyop']['publish_date'])) ?>
	</div>
	<img src="/img/v3/layout/blk-px.png" alt="" border='0' data-original='<?php echo $thumb_url; ?>' width='300' class='lazy'>
	<div class="post-title">
		<?php echo $this->Text->truncate(strtoupper($post['Dailyop']['name']),25); ?>
	</div>
	<div class="post-sub-title">
		<?php echo $this->Text->truncate($post['Dailyop']['sub_title'],50); ?>&nbsp;
	</div>
</div>