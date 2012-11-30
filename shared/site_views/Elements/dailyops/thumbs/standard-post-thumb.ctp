<div class='post-thumb standard-post-thumb'>
<?php 

	$media_file = $post['DailyopMediaItem'][0]['MediaFile'];
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
							"h"=>200,
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