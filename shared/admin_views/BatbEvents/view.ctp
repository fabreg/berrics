<?php

//featured match id's
$featured_matches = array();

$featured_matches[] = $event['BatbEvent']['featured_match1_id'];
$featured_matches[] = $event['BatbEvent']['featured_match2_id'];

//featured stats match id's
$featured_stats = array();

$featured_stats[] = $event['BatbEvent']['featured_stats1_id'];
$featured_stats[] = $event['BatbEvent']['featured_stats2_id'];


$week_drop = array();
for($i=1;$i<=20;$i++) {
	
	$week_drop[$i] = "Week ".$i;
	
}



?>
<script>

$(document).ready(function() { 


	$("#BatbMatchPlayerUpdateViewForm").submit(function() { 


		return confirm("Are you sure you want to select \n================\n"+player1+" \nVS. \n"+player2+" ?");
		
		
		return false;
		

	});

	$("#BatbMatchWinnerUpdateViewForm").submit(function() { 

		var match_winner = $(this).find("#BatbMatchMatchWinnerUserId option:selected").text();

		var rps_winner = $(this).find("#BatbMatchRpsWinnerUserId option:selected").text();

		var winner_letters = $(this).find("#BatbMatchWinnerLetters option:selected").text();

		//validate the shit
		if(match_winner.length<=0 || rps_winner.length<=0 || winning_letters.length<=0) {


			alert("You know if you tried selecting all the winning attributes you wouldn't have gotten this annoying message!");

		} else {


			return confirm("Are you sure you want to end this match with the following information? \n ===================== \n RPS Winner: "+rps_winner+"\n Winning Skater: "+match_winner+" \n Winner's Letters: "+winner_letters);

		}


		return false;

		

		
		
	});

	
});


function userSelected(user,field) {

	var ele = $("#"+field);

	$(ele).val(user.User.id);

	$(ele).parent().find("."+field).html(user.User.first_name+" "+user.User.last_name);

	UserSearch.closeModal();
}



</script>
<style>

#BatbMatchWinnerUpdateViewForm select {


	width:50%;


}

.winning-col div {

	padding:2px;

}

.players-cell div {

	padding:2px;

}

</style>
 <div class='view'>
	<h2>Viewing Event: <?php echo $event['BatbEvent']['name']; ?></h2>
	<div style='text-indent:30px; font-weight;bold; font-style:italic;'>Created: <?php echo $this->Time->niceShort($event['BatbEvent']['created']); ?></div>

	
</div>
<div class='index'>
	<h3 style='padding:5px;'>Brackets</h3>
	<hr />
		<?php foreach($event['Brackets'] as $k=>$v): ?>
		<h4 style='padding:5px;'>
		
		<?php if($k > 0): ?>
			Bracket: <?php echo $k; ?> / Total Matches: <?php echo count($v); ?>
		<?php else:?>
			Consolation Match
		<?php endif; ?>
		</h4>
		<?php 
		
			//lets do some checking 
			$total_brackets = BatbMatch::totalBrackets($event['BatbEvent']['num_players']);	
		
			//is the the top bracket? If so then we need to have players select in order allow the selecting of winners
			$top_bracket = false;
			if($total_brackets == $k) {
				
				$top_bracket = true;
				
			}
			
			if($top_bracket) {

				
			} else {
				
				
				
			}
		
		?>
		<table cellspacing='0'>
			<tr>
				<th width='4%' nowrap >Match #</th>
				<th width='20%'>? VS. ?</th>
				<th width='20%'>Results</th>
				<th>Actions</th>
			</tr>
		
		
		
			<?php 
				foreach($v as $match):
					
				//are we in the top bracket? If so the let's check to see if there has been a player selected
					if($top_bracket) {
						
						//name tokens
						$player1_name = $player2_name = "";
						if(isset($match['Player1User']['id'])) {
							
							
							$player1_name = $match['Player1User']['first_name']." ".$match['Player1User']['last_name'];
							
						}
						
						
						if(isset($match['Player2User']['id'])) {
							
							$player2_name = $match['Player2User']['first_name']." ".$match['Player2User']['last_name'];
							
							
						}
						
						//die(pr($event));
						
						//check to see if player 1 have been selected
						//$player1_html = "<div>".$this->Form->select("BatbMatch.player1_user_id",$userSelect,$match['BatbMatch']['player1_user_id'],array("empty"=>true,"style"=>"width:40%;"))."</div>";
						//$player2_html = "<div>".$this->Form->select("BatbMatch.player2_user_id",$userSelect,$match['BatbMatch']['player2_user_id'],array("empty"=>true,"style"=>"width:40%;"))."</div>";
						$player1_html = "<div><div class='Player1UserId".$match['BatbMatch']['id']."'>{$player1_name}</div><a href=\"javascript:UserSearch.openSearch('userSelected','Player1UserId".$match['BatbMatch']['id']."')\">Click Here to Select Player 1</a>".$this->Form->input("BatbMatch.player1_user_id",array("type"=>"hidden","id"=>"Player1UserId".$match['BatbMatch']['id']))."</div>";
						$player2_html = "<div><div class='Player2UserId".$match['BatbMatch']['id']."'>{$player2_name}</div><a href=\"javascript:UserSearch.openSearch('userSelected','Player2UserId".$match['BatbMatch']['id']."')\">Click Here to Select Player 2</a>".$this->Form->input("BatbMatch.player2_user_id",array("type"=>"hidden","id"=>"Player2UserId".$match['BatbMatch']['id']))."</div>";
						//have we already completed the top brackets games?
						//if so then we can no longer update the players in the match
						if(!empty($match['BatbMatch']['match_winner_user_id'])) {
							
							$player_submit = '';
							
						} else {
							
							$player_submit = $this->Form->submit("Update");
							
						}
						
						
						
						
					} else {
						
						
						//check for player 1
						if(!empty($match['BatbMatch']['player1_user_id'])) {
							
							$player1_html = "<div><strong>".$userSelect[$match['BatbMatch']['player1_user_id']]."</strong></div>";
							
						} else {
							
							$player1_html = '?';
							
						}
						
						//check for player 2
						if(!empty($match['BatbMatch']['player2_user_id'])) {
							
							$player2_html = "<div><strong>".$userSelect[$match['BatbMatch']['player2_user_id']]."</strong></div>";
							
						} else {
							
							$player2_html = '?';
							
						}
						
						
					//	$player2_html = $userSelect[$match['BatbMatch']['player2_user_id']];
						$player_submit = '';
						
					}
					
					//winner column stuff
					
					if(($match['BatbMatch']['player1_user_id']<=0) || ($match['BatbMatch']['player2_user_id']<=0)) {
						
						
						if($top_bracket) {
							
							$winning_col = "You can't choose a winner until you select and save who's playing";
							
						} else {
							
							$winning_col = "We're still waiting for the result of the previous match's";
							
						}
						
						
						
					} else if(empty($match['BatbMatch']['match_winner_user_id']) || empty($match['BatbMatch']['rps_winner_user_id'])) {
						
						//first we gotta create an array for a select list of the player in the current match
						$winner_list = array();
						//$winner_list[$match['BatbMatch']['player1_user_id']] = $userSelect[$match['BatbMatch']['player1_user_id']];
						//$winner_list[$match['BatbMatch']['player2_user_id']] = $userSelect[$match['BatbMatch']['player2_user_id']];
						
						$winner_list[$match['Player1User']['id']] = $match['Player1User']['first_name']." ".$match['Player1User']['last_name'];
						$winner_list[$match['Player2User']['id']] = $match['Player2User']['first_name']." ".$match['Player2User']['last_name'];
						
						
						$winning_col  = "<div><strong>RPS Winner:</strong> ".$this->Form->select("BatbMatch.rps_winner_user_id",$winner_list,NULL,array("empty"=>true))."</div>";
						$winning_col .= "<div><strong>Winning Skater:</strong> ".$this->Form->select("BatbMatch.match_winner_user_id",$winner_list,NULL,array("empty"=>true))."</div>";
						$winning_col .= "<div><strong>Winner's Letters:</strong> ".$this->Form->select("BatbMatch.winner_letters",$winningLettersDrop)."</div>";
						$winning_col .= "<div><strong>Week #</strong> ".$this->Form->select("BatbMatch.week_num",$week_drop)."</div>"; 
						$winning_col .= " ".$this->Form->submit("Update",array("div"=>false));
						
						//$winning_col = $this->Form-.input(;
						
					} else {
						
						//We must have a winner! Let's show the shit that we have in the database
						//$winning_col = "We hav a winner but i havene't coded this shit yet";
						
						$winning_col = "<div><strong>RPS Winner:</strong> ".$userSelect[$match['BatbMatch']['rps_winner_user_id']]."</div>";
						$winning_col .= "<div><strong>Winning Skater:</strong> ".$userSelect[$match['BatbMatch']['match_winner_user_id']]."</div>";
						$winning_col .= "<div><strong>Winners Letters: </strong>".$winningLettersDrop[$match['BatbMatch']['winner_letters']]."</div>";
						$winning_col .= "<div><strong>Week ".$match['BatbMatch']['week_num']."</strong></div>";
						
					}
					
					//do some colors
					
					
					
			?>
			
			
				<tr>
					<td width='1%' nowrap align='center'><?php echo $match['BatbMatch']['match_num']; ?></td>
					<td width='20%' style='text-align:center;' class='players-cell'>
						<?php 
						
							echo $this->Form->create("BatbMatchPlayerUpdate",array("url"=>array("controller"=>"batb_events","action"=>"update_match_players"))); 
							echo $this->Form->input("BatbMatch.id",array("value"=>$match['BatbMatch']['id']));
						?>
						
						<?php echo $player1_html; ?> VS. <?php echo $player2_html; ?> <?php echo $player_submit; ?>
						<?php echo $this->Form->end(); ?>
						<?php if($match['BatbMatch']['next_bracket_num']>0): ?>
						<div style='font-size:11px; font-style:italic; padding:2px; color:green;'>
							( Winner moves on to Bracket: <?php echo $match['BatbMatch']['next_bracket_num']; ?> Match: <?php echo $match['BatbMatch']['next_match_num']; ?> )
						</div>
						<?php endif; ?>
						<?php if($match['BatbMatch']['bracket_num']<$total_brackets): ?>
						<div>
							<?php echo $this->Admin->link("(Flip Positions)",array("controller"=>"batb_events","action"=>"flip_positions",$match['BatbMatch']['id'])); ?>
						</div>
						<?php endif; ?>
					</td>
					<td width='20%' class='winning-col'>
						<?php echo $this->Form->create("BatbMatchWinnerUpdate",array("url"=>array("controller"=>"batb_events","action"=>"update_match_winners"))); ?>
						<?php echo $this->Form->input("BatbMatch.id",array("value"=>$match['BatbMatch']['id'])); ?>
						<?php echo $this->Form->input("BatbMatch.batb_event_id",array("type"=>"hidden","value"=>$event['BatbEvent']['id'])); ?>
						<?php echo $winning_col; ?>
						<?php echo $this->Form->end(); ?>
					</td>
					<td class='' align='center' valign='middle' width='10%'>
						<?php echo $this->Admin->link("Update Video Links",array("controller"=>"batb_events","action"=>"update_videos",$match['BatbMatch']['id'])); ?><br />
						<?php echo $this->Admin->link("Update Match Stats",array("controller"=>"batb_events","action"=>"update_match_stats",$match['BatbMatch']['id'])); ?>
						<?php 
						
							if(!in_array($match['BatbMatch']['id'],$featured_matches)) {
								echo "<br />";
								echo "<br />";
								echo $this->Admin->link("Mark as Saturday",array("controller"=>"batb_events","action"=>"mark_as_featured",$match['BatbMatch']['id'],1));
								echo "<br />";
								echo $this->Admin->link("Mark as Sunday",array("controller"=>"batb_events","action"=>"mark_as_featured",$match['BatbMatch']['id'],2));
								echo "<br />";
								
							} else {
								
								echo "<div style='color:red; font-weight:bold'>Marked As Featured Match</div>";
								
							}
							
							
							if(!in_array($match['BatbMatch']['id'],$featured_stats)) {
								
								echo "<br />";
								echo $this->Admin->link("Mark as Featured Stats 1",array("controller"=>"batb_events","action"=>"mark_as_featured_stats",$match['BatbMatch']['id'],1));
								echo "<br />";
								echo $this->Admin->link("Mark as Featured Stats 2",array("controller"=>"batb_events","action"=>"mark_as_featured_stats",$match['BatbMatch']['id'],2));
								
							} else {
								
								echo "<div style='color:red; font-weight:bold'>Marked In Featured Stats</div>";
								
							}
							
						
						?>
					</td>
				</tr>
			
			
			
			<?php 
				endforeach;
			?>
		</table>
		<?php endforeach; ?>

</div>
<?php 

//pr($event);


?>