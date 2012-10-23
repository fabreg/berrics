<?php 


$d = $dop['Dailyop'];
$m = $dop['DailyopMediaItem'][0]['MediaFile'];



?>
<div class='post-thumb-large post-thumb' showBubble='false' media_type='<?php echo $m['media_type']; ?>'>
	<div class='inner'>
		<div class='title'>
			
			<a href='/<?php echo $dop['DailyopSection']['uri']; ?>/<?php echo $d['uri']; ?>' title='<?php echo $d['name']; ?>'>
			<?php 
			
				echo strtoupper($d['name']);
			
			?>
			</a>
		</div>
		<div class='sub-title'>		
			
			<?php 
				echo $d['sub_title'];
			
			?>
			
		</div>
		<hr />
		<div class='media'>
			<div class='post-thumb-large-over'></div>
			<?php 
			
				$thumb = $this->Media->mediaThumb(array(
				
					"MediaFile"=>$m,
					"w"=>320,
					"h"=>185
				
				));
				
			?>
			<a href='/<?php echo $dop['DailyopSection']['uri']?>/<?php echo $d['uri']; ?>'><?php echo $thumb; ?></a>
		</div>
		<div class='date'>
			<?php 
			
				echo $this->Time->niceShort($d['publish_date']);
			
			?>
		</div>
	</div>
</div>