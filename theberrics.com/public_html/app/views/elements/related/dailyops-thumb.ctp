<?php 

$f = $dop['DailyopMediaItem'][0]['MediaFile'];
$d = $dop['Dailyop'];

?>
<div class='thumb'>
	<div class='img'>
		<?php 
		
			$thumb =  $this->Media->mediaThumb(array(
			
				"MediaFile"=>$f,
				"w"=>215,
				"h"=>125
			
			),array("border"=>0));
		
			echo $this->Berrics->dailyopsPostLink($thumb,$dop,array("escape"=>false));
			
		?>
	</div>
	<div class='info'>
		<div class='icon'>
			<?php echo $this->Media->sectionIcon(array(
			
				"DailyopSection"=>$dop['DailyopSection'],
				"w"=>30,
				"h"=>30
			
			)); ?>
		</div>
		<div class='title'>
			<?php echo $d['name']; ?>
			<?php 
				
				if(!empty($d['sub_title'])):
			
			?>
			<div class='sub-title'>
				<?php echo $d['sub_title']; ?>
			</div>
			<?php 
			
				endif;
			
			?>
		</div>
		
		
		<div class='date'>
			<?php echo $this->Time->niceShort($dop['Dailyop']['publish_date']);?>
		</div>
	</div>
</div>
