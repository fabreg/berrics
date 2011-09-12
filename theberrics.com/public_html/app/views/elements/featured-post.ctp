<div id='featured-post'>
	<div class='inner'>
		<div class='title'>
			<?php echo strtoupper($featured_post['Dailyop']['name']); ?>
			<?php 
				if(!empty($featured_post['Dailyop']['sub_title'])):
			?>
			<div class='sub-title'>
				<?php echo $featured_post['Dailyop']['sub_title']; ?>
			</div>
			<?php 
				endif;
			?>
		</div>
		<div class='thumb'>
			<div class='featured-thumb-over'></div>
			<a href='/<?php echo $featured_post['DailyopSection']['uri']; ?>/<?php echo $featured_post['Dailyop']['uri']; ?>'>
			<?php 
			
				echo $this->Media->mediaThumb(array(
				
					"MediaFile"=>$featured_post['DailyopMediaItem'][0]['MediaFile'],
					"w"=>275,
					"h"=>160
				),array("border"=>0));
			
			?>
			</a>
		</div>
	</div>
</div>