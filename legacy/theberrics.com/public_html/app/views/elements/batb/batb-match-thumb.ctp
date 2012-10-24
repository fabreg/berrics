<?php 

$media_file = $dop['DailyopMediaItem'][0]['MediaFile'];

$link = "/".$this->params['section']."/view:".$dop['Dailyop']['uri'];

?>
<div class='batb-match-thumb'>
				<?php 
					
					$thumb = $this->Media->mediaThumb(array(
					
						"MediaFile"=>$media_file,
						"w"=>200
					
					));
					echo "<a href='{$link}'>{$thumb}</a>";
				?>
</div>