<?php

$player1 =  $users[$match['BatbMatch']['player1_user_id']]; 
$player2 =  $users[$match['BatbMatch']['player2_user_id']]; 

if(

	isset($match['PreGamePost']['Dailyop']['id']) ||
	isset($match['BattlePost']['Dailyop']['id']) ||
	isset($match['PostGamePost']['Dailyop']['id'])
	
) {
	
		
	$url = "/".$this->params['section']."/view:".Tools::safeUrl($player1['first_name']." ".$player1['last_name']." vs ".$player2['first_name']." ".$player2['last_name']);
		
} else {
	
	$url = false;
	
}
?>
<div id='finals_bracket_<?php echo $match['BatbMatch']['bracket_num']; ?>_match_<?php echo $match['BatbMatch']['match_num']; ?>' class='finals_match finals_bracket_<?php echo $match['BatbMatch']['bracket_num']; ?>'>
	
	<div class='player1'>
		
			
		
		<?php 	
			
			$p1 .= strtoupper($player1['first_name'])." ".strtoupper($player1['last_name']); 
			if($url) {
					
							$p1 = $this->Html->link($p1,$url,array("escape"=>false));
							
			}
		?>	
		
		<?php if(strlen($p1)>1): ?>
		
			<img src='/theme/battle-at-the-berrics-4/img/flags_sm/<?php echo strtolower($player1['country']); ?>.png' />
		
		<?php endif; ?>
		<?php 
			
			echo $p1;
			
			
		?>
	</div>
	<div class='spacer'></div>
	<div class='player2'>
		
			
		
		<?php
			
			
			$p2 = strtoupper($player2['first_name'])." ".strtoupper($player2['last_name']); 
			if($url) {
					
							$p2 = $this->Html->link($p2,$url);
							
			}
			
		?>
		
		<?php if(strlen($p2)>1): ?>
		
			<img src='/theme/battle-at-the-berrics-4/img/flags_sm/<?php echo strtolower($player2['country']); ?>.png' />
		
		<?php endif; ?>
		<?php 
			
			
			echo $p2;
			
		?>
	</div>

</div>
