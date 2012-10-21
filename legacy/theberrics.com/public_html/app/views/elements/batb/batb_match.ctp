<?php

$player1 =  $users[$match['BatbMatch']['player1_user_id']]; 
$player2 =  $users[$match['BatbMatch']['player2_user_id']]; 


//build the url

if(!empty($match['BatbMatch']['pregame_media_file_id']) ||
	!empty($match['BatbMatch']['video_media_file_id']) ||
	!empty($match['BatbMatch']['postgame_media_file_id'])) {
	
		
	$url = "/".$this->params['section']."/view:".Tools::safeUrl($player1['first_name']." ".$player1['last_name']." vs ".$player2['first_name']." ".$player2['last_name']);
		
} else {
	
	$url = false;
	
}

?>

<?php 

if($match['BatbMatch']['bracket_num'] == 0 && $match['BatbMatch']['match_num'] == 1):

$winner = $users[$match['BatbMatch']['match_winner_user_id']];


?>
<div id='third'>
	<a href='<?php echo $url; ?>'>	
	<?php 
	
		echo strtoupper($winner['first_name']." ".$winner['last_name']);
	
	?>
	</a>
</div>
<?php 

else:


?>

<div id='bracket_<?php echo $match['BatbMatch']['bracket_num']; ?>_match_<?php echo $match['BatbMatch']['match_num']; ?>' class='match bracket_<?php echo $match['BatbMatch']['bracket_num']; ?>'>
	
	<div class='player1'>
	
		<?php 
			if($match['BatbMatch']['bracket_num']<5) {
				
				$p1 = substr(strtoupper($player1['first_name']),0,1).". ".strtoupper($player1['last_name']);
				
				
			} else {

						$p1 = strtoupper($player1['first_name'])." ".strtoupper($player1['last_name']); 

				
			}
			
			if($url) {
					
							$p1 = $this->Html->link($p1,$url);
							
			}
			
			echo $p1;
			
		?>
	</div>
	<div class='spacer'></div>
	<div class='player2'>
	
		<?php
			if($match['BatbMatch']['bracket_num']<5) {
				
				$p2 = substr(strtoupper($player2['first_name']),0,1).". ".strtoupper($player2['last_name']);
						
				 
			} else {
				
				$p2 = strtoupper($player2['first_name'])." ".strtoupper($player2['last_name']); 
				
			}
			
			if($url) {
					
							$p2 = $this->Html->link($p2,$url);
							
			}
			
			echo $p2;
		?>
	</div>

</div>
<?php 

endif;

?>
