<?php
$this->Html->css("batb","stylesheet",array("inline"=>false));

//for the posts
$this->Html->script(array("dailyops/post-bit"),array("inline"=>false));

$winner = $users[$event['BatbEvent']['first_place_user_id']];
$second = $users[$event['BatbEvent']['second_place_user_id']];
$third = $users[$event['BatbEvent']['third_place_user_id']];
?>
<script>
$(document).ready(function() { 


	var scrollDown = false;

	<?php 
		
		
	
		if(isset($this->request->params['uri']) || isset($this->request->params['named']['view'])) {
			
			
			echo "scrollDown=true;";
			
		}
	
	
	?>


	if(scrollDown) {

		$(window).scrollTo(820);

	}
	

	
});




</script>

<div id='batb-view'>

	<div class="header">
 			<?php 
 			
 				echo $this->Html->image("layout/batbbracketnavhead.jpg");
 			
 			?>
		</div>
		
	<div id='brackets'>
		<?php 
		
		
				foreach($event['Brackets'] as $bracket) {
			
					foreach($bracket as $match_bit) {
						
						echo $this->element("batb/batb_match",array("match"=>$match_bit,"users"=>$users));
						
					}
					
				}
			
		
		?>
		<div id='winner'><?php echo strtoupper($winner['first_name'].' '.$winner['last_name']);?> </div>
		<div id='second'><?php echo strtoupper($second['first_name'].' '.$second['last_name']); ?></div>
	</div>
	
</div>
<div id='extra-stuff'>

	<?php 
	
		echo $this->element("batb/extra-stuff");
	
	?>

</div>

<div id='posts' style='width:728px; margin:auto; padding-top:20px;'>
		<?php 
	

			if(isset($post)) {
				
				echo $this->element("dailyops/post-bit",array("dop"=>$post));
				
			}
	
		?>
		
		<?php 
		
			if(isset($match)) {
				
				$p1 = $users[$match['BatbMatch']['player1_user_id']];
				$p2 = $users[$match['BatbMatch']['player2_user_id']];
				$vs = $p1['first_name']." ".$p1['last_name']." VS ".$p2['first_name']." ".$p2['last_name'];
				
				//pre game
				if(isset($match['PreGameVideo']['id'])) {
					
					
					$dop = array(
					
						"Dailyop"=>array(
							"name"=>"Pre-Game",
							"sub_title"=>$vs
						),
						"DailyopMediaItem"=>array(
							0=>array(
								"MediaFile"=>$match['PreGameVideo']
							)
						)
					
					);
					
					
					echo $this->element("dailyops/post-bit",array("dop"=>$dop));
					echo "<div style='height:20px;'></div>";
				}
				
				
				//battle
				if(isset($match['BattleVideo']['id'])) {
					
					$dop = array(
					
						"Dailyop"=>array(
							"name"=>"Battle",
							"sub_title"=>$vs
						),
						"DailyopMediaItem"=>array(
							0=>array(
								"MediaFile"=>$match['BattleVideo']
							)
						)
					
					);
					
					
					echo $this->element("dailyops/post-bit",array("dop"=>$dop));
					echo "<div style='height:20px;'></div>";
				}
				
				//post game
				if(isset($match['PostGameVideo']['id'])) {
					
					$dop = array(
					
						"Dailyop"=>array(
							"name"=>"Post-Game",
							"sub_title"=>$vs
						),
						"DailyopMediaItem"=>array(
							0=>array(
								"MediaFile"=>$match['PostGameVideo']
							)
						)
					
					);
					
					
					echo $this->element("dailyops/post-bit",array("dop"=>$dop));
					
				}
				
			}
		
		
		?>
		
</div>
<div id='batb-rounds'>
	<?php 
		$total_rounds = BatbMatch::totalBrackets($event['BatbEvent']['num_players']);
		
		$flipped = array_reverse($event['Brackets'],true);
		
		foreach($flipped as $round=>$bracket):
			//check to see if we have at lease one battle video
			
			$check = Set::extract("/BatbMatch/video_media_file_id[text=/[0-9a-zA-Z\-]/]",$bracket);
			if(count($check)<=0) {
				
				continue;
				
			}
			
	?>
	
		<div class='round-title'>Round <?php echo ($total_rounds - $round)+1;?></div>
			
				<?php 
				
					foreach($bracket as $match):
						$media_file = false;
						
						if(isset($match['BattleVideo']['id'])) {
							
							$media_file = $match['BattleVideo'];
							
						} else if(isset($match['PreGameVideo']['id'])) {
							
							$media_file = $match['PreGameVideo'];
							
						} else if(isset($match['PostGameVideo']['id'])) {
							
							$media_file = $match['PostGameVideo'];
							
						}
							
				?>
			
				<?php 
				
					if($media_file) {
						
						$p1 = $users[$match['BatbMatch']['player1_user_id']];
						$p2 = $users[$match['BatbMatch']['player2_user_id']];
						
						$dop = array(
						
							"Dailyop"=>array(
								"name"=>$p1['first_name']." ".$p1['last_name']." VS ".$p2['first_name']." ".$p2['last_name'],
								"uri"=>Tools::safeUrl($p1['first_name']." ".$p1['last_name']." VS ".$p2['first_name']." ".$p2['last_name']),
							),
							"DailyopSection"=>array(
							
								"uri"=>$this->request->params['section']	
							
							),
							"DailyopMediaItem"=>array(
						
								0=>array(
									"MediaFile"=>$media_file
								)	
						
							)
						
						);
						
						echo $this->element("batb/batb-match-thumb",array("dop"=>$dop));
						
					}		
						
				?>
			
		<?php 
				
			endforeach;
		
		?>
		<div style='clear:both;'></div>
	<?php 
	
		endforeach;
	
	?>
</div>