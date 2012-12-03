<div class='post news-post'>
	<div class="clearfix">
		<div class="image">
			<?php 

				
				 echo $this->Media->mediaThumb(array(
				"MediaFile"=>$post['DailyopTextItem'][0]['MediaFile'],
				"w"=>350,
				"h"=>200,
				"zc"=>1
			)); 
			?>
		</div>
		<div class="summary">
			<h3><?php echo $post['Dailyop']['name']; ?> <br /> <small><?php echo $post['Dailyop']['sub_title']; ?>&nbsp;</small></h3>
		</div>
	</div>
</div>