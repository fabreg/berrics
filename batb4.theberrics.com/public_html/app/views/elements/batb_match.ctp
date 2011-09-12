<?php

$player1 =  $users[$match['BatbMatch']['player1_user_id']]; 
$player2 =  $users[$match['BatbMatch']['player2_user_id']]; 

?>
<div id='bracket_<?php echo $match['BatbMatch']['bracket_num']; ?>_match_<?php echo $match['BatbMatch']['match_num']; ?>' class='match bracket_<?php echo $match['BatbMatch']['bracket_num']; ?>'>
	
	<div class='player1'>
		<?php if($match['BatbMatch']['bracket_num']==5 && !empty($player1)): ?>
			<img src='/img/flags_sm/<?php echo strtolower($player1['country']); ?>.png' />
		<?php endif; ?>
		<?php 
			if($match['BatbMatch']['bracket_num']<5) {
				
				$p1 = substr(strtoupper($player1['first_name']),0,1).". ".strtoupper($player1['last_name']);
				
				if(!empty($match['BatbMatch']['legacy_video_link'])) {
					
					$p1 = $this->Html->link($p1,$match['BatbMatch']['legacy_video_link'],array("target"=>"_blank"));
					
				}
				
				echo $p1;
				 
				
			} else {
				//bracket_5_match_2
				
				
				
				
				
				if($match['BatbMatch']['bracket_num'] == 5 && $match['BatbMatch']['match_num'] == 2) {
					
					$p1 .= "<img style='margin-left:30px; margin-top:-7px;' src='/img/layout/malto.png'/>";
					
				} else {
					
					
					$p1 = strtoupper($player1['first_name'])." ".strtoupper($player1['last_name']); 
					
					
						if(!empty($match['BatbMatch']['legacy_video_link'])) {
					
							$p1 = $this->Html->link($p1,$match['BatbMatch']['legacy_video_link'],array("target"=>"_blank"));
							
						}
				
					
				}
			
			
				
				echo $p1;
				
			}
			
			
		?>
	</div>
	<div class='spacer'></div>
	<div class='player2'>
		<?php if($match['BatbMatch']['bracket_num']==5 && !empty($player2)): ?>
			<img src='/img/flags_sm/<?php echo strtolower($player2['country']); ?>.png' />
		<?php endif; ?>
		<?php
			if($match['BatbMatch']['bracket_num']<5) {
				
				$p2 = substr(strtoupper($player2['first_name']),0,1).". ".strtoupper($player2['last_name']);
				
				if(!empty($match['BatbMatch']['legacy_video_link'])) {
					
					$p2 = $this->Html->link($p2,$match['BatbMatch']['legacy_video_link'],array("target"=>"_blank"));
					
				}
				
				echo $p2;
				 
			} else {
				
				$p2 = strtoupper($player2['first_name'])." ".strtoupper($player2['last_name']); 
			
				if(!empty($match['BatbMatch']['legacy_video_link'])) {
					
					$p2 = $this->Html->link($p2,$match['BatbMatch']['legacy_video_link'],array("target"=>"_blank"));
					
				}
				
				echo $p2;
				
			}
		?>
	</div>

</div>
