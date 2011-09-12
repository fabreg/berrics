<?php

	$p1 = $vote['BatbMatch']['Player1User'];
	$p2 = $vote['BatbMatch']['Player2User'];
	$match = $vote['BatbMatch'];
	$letters = BatbMatch::winningLettersDrop();
	
?>
<div class='vote'>
<table cellspacing='0'>
	<tr class='title-row'>
		<td class='left'><img src='/img/flags_sm/<?php echo strtolower($p1['country']); ?>.png' /> <?php echo $p1['first_name']; ?> <?php echo $p1['last_name']?></td>
		<td class='center'>VS.</td>
		<td class='right'><img src='/img/flags_sm/<?php echo strtolower($p2['country']); ?>.png' /> <?php echo $p2['first_name']; ?> <?php echo $p2['last_name']; ?></td>
		<td class='result'>Result</td>
	</tr>
	<tr>
		<td class='left'>
		<?php 
		
			if($vote['BatbVote']['rps_winner_user_id'] == $p1['id']) {

				echo $this->Html->image("layout/check-bg-selected.png");
				
			}
		?>&nbsp;
		</td>
		<td class='center' nowrap>RO-SHAM-BO</td>
		<td class='right'>
		<?php 
		if($vote['BatbVote']['rps_winner_user_id'] == $p2['id']) {

				echo $this->Html->image("layout/check-bg-selected.png");
				
			}
		?>&nbsp;
		</td>
		<td class='result'>
			<?php 
			if(strlen($match['rps_winner_user_id'])>0) {
				
				echo $vote['BatbVote']['rps_points'];
				
			} else {
				
				echo "?";
				
			}

			?>&nbsp;
		</td>
	</tr>
	<tr>
		<td class='left'>
		<?php 
		
			if($vote['BatbVote']['match_winner_user_id'] == $p1['id']) {

				echo $this->Html->image("layout/check-bg-selected.png");
				
			}
		?>&nbsp;
		</td>
		<td class='center'>WINNER</td>
		<td class='right'>
		<?php 
		
			if($vote['BatbVote']['match_winner_user_id'] == $p2['id']) {

				echo $this->Html->image("layout/check-bg-selected.png");
				
			}
		?>&nbsp;
		</td>
		<td class='result'>
			<?php 
			if(strlen($match['match_winner_user_id'])>0) {
				
				echo $vote['BatbVote']['match_points'];
				
			} else {
				
				echo "?";
				
			}

			
			?>&nbsp;
		</td>
	</tr>
	<tr>
		<td class='left'>
		<?php 
			
			if($vote['BatbVote']['match_winner_user_id'] == $p1['id']) {
				
				echo $letters[$vote['BatbVote']['winner_letters']];
				
			}
		
		?>&nbsp;
		</td>
		<td class='center'>FINAL LETTERS</td>
		<td class='right'>
		<?php 
			
			if($vote['BatbVote']['match_winner_user_id'] == $p2['id']) {
				
				echo $letters[$vote['BatbVote']['winner_letters']];
				
			}
		
		?>&nbsp;
		</td>
		<td class='result'>
		<?php 
			
			if(strlen($match['match_winner_user_id'])>0) {
						
				echo $vote['BatbVote']['letters_points'];
				
			} else {
				
				echo "?";
				
			}

			
			?>&nbsp;
		</td>
	</tr>

</table>
</div>