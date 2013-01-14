<div class='post-thumb standard-post-thumb' data-dailyop-id='<?php echo $post['Dailyop']['id']; ?>'>
<?php 

	$media_file = $post['DailyopMediaItem'][0]['MediaFile'];

	if($post['Dailyop']['dailyop_section_id'] == 65) {

		$media_file = $post['DailyopTextItem'][0]['MediaFile'];

	}

	$url = $this->Berrics->dailyopsPostUrl($post);
?>
	<div class="post-date">
		<?php echo date("m.d.Y",strtotime($post['Dailyop']['publish_date'])) ?>
	</div>
	<div class="thumb">
		<a href="<?php echo $url; ?>">
		<div class="overlay"></div>
		<?php if ($media_file['media_type'] == "bcove"): ?>
			<div class="play-button"></div>
		<?php endif ?>
		<?php 
			echo $this->Media->mediaThumb(array(
				"MediaFile"=>$media_file,
				"w"=>350,
				"h"=>180,
				"zc"=>1,
				"lazy"=>true
			)); 
		?>
		</a>
	</div>
	<div class="post-title">
		<a href='<?php echo $this->Berrics->dailyopsPostUrl($post); ?>'><?php echo $this->Text->truncate(strtoupper($post['Dailyop']['name']),25); ?></a>
	</div>
	<div class="post-sub-title">
		<?php echo $this->Text->truncate($post['Dailyop']['sub_title'],50); ?>&nbsp;
	</div>
</div>