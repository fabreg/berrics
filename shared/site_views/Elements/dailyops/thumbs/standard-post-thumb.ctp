<div class='post-thumb standard-post-thumb'>
<?php 

	$media_file = $post['DailyopMediaItem'][0]['MediaFile'];
	
?>
	<div class="post-date">
		<?php echo date("m.d.Y",strtotime($post['Dailyop']['publish_date'])) ?>
	</div>
	<?php 
					echo $this->Media->mediaThumb(array(
						"MediaFile"=>$media_file,
						"w"=>350,
						"h"=>200,
						"lazy"=>true
					)); 
	?>
	<div class="post-title">
		<?php echo $this->Text->truncate(strtoupper($post['Dailyop']['name']),25); ?>
	</div>
	<div class="post-sub-title">
		<?php echo $this->Text->truncate($post['Dailyop']['sub_title'],50); ?>&nbsp;
	</div>
</div>