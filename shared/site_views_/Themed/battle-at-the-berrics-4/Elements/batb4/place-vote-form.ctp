<?php 


?>
<div id='place-vote'>


	<div id='players'>
		<div id='player1'>
			<img src='/img/flags/<?php echo strtolower($match['Player1User']['country']); ?>.png' /> <br />
			<?php echo strtoupper($match['Player1User']['first_name']." ".$match['Player1User']['last_name']); ?>
		</div>
		<div id='player2'>
			<img src='/img/flags/<?php echo strtolower($match['Player2User']['country']); ?>.png' /> <br />
			<?php echo strtoupper($match['Player2User']['first_name']." ".$match['Player2User']['last_name']); ?>
		</div>
		<div id='vs'>
			VS.
		</div>
		<div style="clear:both;"></div>
	</div>
	
</div>
<hr />
<table cellspacing='0' id='voting-table' featured_num='<?php echo $featured_num; ?>'>

	<tr id='rps-winner-row'>
		<td class='left'>
			<div class='checkbox' user_id='<?php echo $match['Player1User']['id']; ?>' featured_num='<?php echo $featured_num; ?>' player='1'>
			
			</div>
		</td>
		<td class='center' nowrap>
			RO-SHAM-BO
		</td>
		<td class='right'>
			<div class='checkbox' user_id='<?php echo $match['Player2User']['id']; ?>' featured_num='<?php echo $featured_num; ?>' player='2'>
			
			</div>
		</td>
	</tr>
	<tr id='match-winner-row'>
		<td class='left'>
			<div class='checkbox' user_id='<?php echo $match['Player1User']['id']; ?>'  featured_num='<?php echo $featured_num; ?>' player='1'>
			
			</div>
		</td>
		<td class='center'>
			WINNER
		</td>
		<td class='right'>
			<div class='checkbox' user_id='<?php echo $match['Player2User']['id']; ?>'  featured_num='<?php echo $featured_num; ?>' player='2'>
			
			</div>
		</td>
	</tr>
	<tr id='winners-letters-row'>
		<td class='left' player='1'>
			<div class='sk8'>
			S.K.A.T.E
			</div>
			<div class='sk8-select'>
				<?php echo $this->Form->select("winner_letters-".$featured_num,BatbMatch::winningLettersDrop(),NULL,array("empty"=>false,"disabled"=>true)); ?>
			</div>
		</td>
		<td class='center'>FINAL LETTERS</td>
		<td class='right' player='2'>
			<div class='sk8'>
			S.K.A.T.E
			</div>
			<div class='sk8-select'>
				<?php echo $this->Form->select("winner_letters-".$featured_num,BatbMatch::winningLettersDrop(),NULL,array("empty"=>false,"disabled"=>true)); ?>
			</div>
		</td>
	</tr>
</table>
<?php 
echo $this->Form->input("match_winner_user_id-".$featured_num,array("type"=>"hidden"));
echo $this->Form->input("rps_winner_user_id-".$featured_num,array("type"=>"hidden"));
echo $this->Form->input("batb_match_id-".$featured_num,array("type"=>"hidden","value"=>$match['BatbMatch']['id']));
?>