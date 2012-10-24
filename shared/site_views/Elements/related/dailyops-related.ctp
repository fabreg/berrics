<?php 


$bg = $this->Media->mediaThumbSrc(array(

	"MediaFile"=>$post['DailyopMediaItem'][0]['MediaFile'],
	"w"=>700,
	"h"=>400

));

?>
<div class='dailyops-related' bg_img='<?php echo $bg; ?>'>
	<div class='inner'>
		<div class='top-title'>
			JUST WATCHED:
			<div class='right'><a href='http://<?php echo $_SERVER['SERVER_NAME']; ?>'>THE BERRICS</a></div>
		</div>
		<div class='just-watched'>
			<?php 
			
				echo $this->Media->sectionIcon(array(
						"w"=>25,
						"h"=>25,
						"DailyopSection"=>$post['DailyopSection']
					),array(
					
						"class"=>"icon"
					
					));
			
			?>
			<?php 
				
				$title = $post['Dailyop']['name'];
			
				if(!empty($title) && !empty($post['Dailyop']['sub_title'])) {
				 	
				 	$title .=" - ";
				 	
				}
				
				$title .= "<span>".$post['Dailyop']['sub_title']."</span>";
				
				echo $title;
					
			?>
		</div>
		<div class='just-watched-buttons'>
			<div class='replay-button'>
				<a href='/<?php echo $post['DailyopSection']['uri']; ?>/<?php echo $post['Dailyop']['uri']; ?>?autoplay'>Replay</a>
			</div>
			<div style='clear:both;'></div>
		</div>
		<div class='top-title'>
			RELATED POSTS:
		</div>
		<div class='related'>
		<?php 
		
			foreach($related as $r):
		
		?>
			<?php 
			
				echo $this->element("related/dailyops-thumb",array("dop"=>$r));
			
			?>
		<?php 
		
			endforeach;
		
		?>
		<div style='clear:both;'></div>
		</div>
		<div class='banner' style='text-align:center; padding:5px; width:100%;'>
		</div>
	</div>
</div>
