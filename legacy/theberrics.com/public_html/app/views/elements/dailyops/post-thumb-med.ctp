<?php 


$m = $dop['DailyopMediaItem'][0]['MediaFile'];

$d = $dop['Dailyop'];

$title = $d['name'];

if(!empty($d['sub_title'])) {
	
	$title .= " - ".$d['sub_title'];
	
}

if(!isset($showBubble)) {
	
	
	$showBubble = true;
	
}


?>
<div class='post-thumb-med  post-thumb' showBubble='<?php echo $showBubble; ?>' name='<?php echo htmlentities($d['name'],ENT_QUOTES); ?>' sub_title='<?php echo htmlentities($d['sub_title'],ENT_QUOTES); ?>' media_type='<?php echo $m['media_type']; ?>' >
	<div class='inner'>
		<div class='img'>
		<div class='post-thumb-med-over'></div>
		<a href='<?php echo $this->Berrics->dailyopsPostUrl($dop); ?>' title='<?php addslashes($title); ?>'>
			<?php 
			
				echo $this->Media->mediaThumb(array(
				
					"MediaFile"=>$m,
					"w"=>"210",
					"h"=>"121"
				
				),array("border"=>"0"));
			
			?>
		</a>
		</div>
		<div class='info'>
			<?php echo $this->Time->niceShort($d['publish_date']); ?>
		</div>
	</div>
</div>