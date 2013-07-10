<?php 

$d = $dop['Dailyop'];
$m = $dop['DailyopMediaItem'][0]['MediaFile'];

$style = '';

if(!empty($dop['DailyopSection']['icon_light_file'])) {
	
	//$style='background-image:url(http://img01theberrics.com/i.php?src=/berrics-icons/'.$dop['DailyopSection']['icon_light_file'].'&w=24&h=24)';
	
}

if(!isset($showBubble)) {
	
	
	$showBubble = true;
	
}


?>
<div class='post-thumb-small post-thumb' showBubble='<?php echo $showBubble; ?>'  name='<?php echo htmlentities($d['name'],ENT_QUOTES); ?>' sub_title='<?php echo htmlentities($d['sub_title'],ENT_QUOTES); ?>' media_type='<?php echo $m['media_type']; ?>'>
	<div class='inner' style='<?php echo $style; ?>' >
	
		<div class='img'>
			<div class='post-thumb-small-over'></div>
			<?php 
				$thumb =  $this->Media->mediaThumb(array(
				
					"MediaFile"=>$m,
					"w"=>155,
					"h"=>90
				
				));
				
				$title = $d['name'];
				
				if(!empty($d['sub_title'])) {
					
					$title .= " - ".$d['sub_title'];
					
				}
				
				echo $this->Berrics->dailyopsPostLink($thumb,$dop,array("escape"=>false,"title"=>$title));
			?>
		</div>
		<div class='date'>
				<div class='icon'>
				<?php 
				
				echo $this->Media->sectionIcon(
					array(
						"DailyopSection"=>$dop['DailyopSection'],
						"w"=>22,
						"h"=>22
					),
					array(
						
					)
				);
				
				?>
				</div>
				<?php 				
					echo strtoupper(date("M d, Y",strtotime($d['publish_date'])));
				?>
				
		</div>
	</div>
</div>