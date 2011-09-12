<?php 


//make list of match 1 and match 2

$match_1_list = array(

	$match_1['Player1User']['id']=>$match_1['Player1User']['first_name']." ".$match_1['Player1User']['last_name'],
	$match_1['Player2User']['id']=>$match_1['Player2User']['first_name']." ".$match_1['Player2User']['last_name']

);

$match_2_list = array(

	$match_2['Player1User']['id']=>$match_2['Player1User']['first_name']." ".$match_2['Player1User']['last_name'],
	$match_2['Player2User']['id']=>$match_2['Player2User']['first_name']." ".$match_2['Player2User']['last_name']

);



?>
<style>


</style>
<script>
$(document).ready(function() { 

	$("#match1 select, #match2 select").change(function() { 

		updateForm();
		$(this).parent().find("label").css({"color":"#000"});
	});

	$("#submit-button").click(function() { 

		var valid = validateVote();

		if(!valid) {

			alert("Please Fix The Fields Highlighted In Red");
			
		} else {

			var conf = confirm("Are you sure you want to confirm your vote?");

			if(conf) {

				$("#batb4-vote form").submit();
				
			}
		}
		
	});
	
});


function updateForm() {

	var RpsWinnerUserIdMatch1 = document.getElementById("RpsWinnerUserIdMatch1");
	var RpsWinnerUserIdMatch2 = document.getElementById("RpsWinnerUserIdMatch2");

	var MatchWinnerUserIdMatch1 = document.getElementById("MatchWinnerUserIdMatch1");
	var MatchWinnerUserIdMatch2 = document.getElementById("MatchWinnerUserIdMatch2");

	
	

	//let's check and populate the winners and losers

	//////battle 1
	var b1winnerLabel = MatchWinnerUserIdMatch1.options[MatchWinnerUserIdMatch1.selectedIndex].innerHTML;
	var b1winnerId = MatchWinnerUserIdMatch1.options[MatchWinnerUserIdMatch1.selectedIndex].value;
	var b1loserLabel = '';
	var b1loserId = '';

	if(b1winnerId.length == 36) {
		$(MatchWinnerUserIdMatch1).find("option").each(function() { 

			var id = $(this).attr("value");
			
			if(id != b1winnerId) {

				b1loserLabel = $(this).html();
				b1loserId = id;
			} 
			

		});
	}


	//pupulate the label
	if(b1winnerLabel.length <= 0) {

		b1loserLabel = b1winnerLabel = "?";
		
	} 

	$("#finals_player1").html(b1winnerLabel);

	
	$("#third_place_player1").html(b1loserLabel);
	
	/////// battle 2
	var b2winnerLabel = MatchWinnerUserIdMatch2.options[MatchWinnerUserIdMatch2.selectedIndex].innerHTML;
	var b2winnerId = MatchWinnerUserIdMatch2.options[MatchWinnerUserIdMatch2.selectedIndex].value;
	var b2loserLabel = '';
	var b2loserId = '';
	if(b2winnerId.length == 36) {

		$(MatchWinnerUserIdMatch2).find("option").each(function() { 

			var id = $(this).attr("value");
			
			if(id != b2winnerId) {

				b2loserLabel = $(this).html();
				b2loserId = id;
			} 
			

		});
		
	}
	

	//pupulate the label
	if(b2winnerLabel.length <= 0) {

		b2loserLabel = b2winnerLabel = "?";
		
	} 

	$("#finals_player2").html(b2winnerLabel);

	
	$("#third_place_player2").html(b2loserLabel);


	//build selects
	var third_user_options = '';
	var champ_user_options = '';
	
	
	////third place battle
	if(b2loserId.length == 36 && b1loserId.length == 36) {

		third_user_options = "<option value='"+b1loserId+"'>"+b1loserLabel+"</option>";
		third_user_options += "<option value='"+b2loserId+"'>"+b2loserLabel+"</option>";
		
	} 

	if(b1winnerId.length == 36 && b2winnerId.length == 36) {

		champ_user_options = "<option value='"+b1winnerId+"'>"+b1winnerLabel+"</option>";
		champ_user_options += "<option value='"+b2winnerId+"'>"+b2winnerLabel+"</option>";
		
	}
	

	$("#RpsWinnerUserIdThird,#MatchWinnerUserIdThird").html(third_user_options);
	$("#RpsWinnerUserIdFinals,#MatchWinnerUserIdFinals").html(champ_user_options);
	
}


function validateVote() {


	var RpsWinnerUserIdMatch1 = document.getElementById("RpsWinnerUserIdMatch1");
	var RpsWinnerUserIdMatch2 = document.getElementById("RpsWinnerUserIdMatch2");

	var MatchWinnerUserIdMatch1 = document.getElementById("MatchWinnerUserIdMatch1");
	var MatchWinnerUserIdMatch2 = document.getElementById("MatchWinnerUserIdMatch2");

	var b1winnerId = MatchWinnerUserIdMatch1.options[MatchWinnerUserIdMatch1.selectedIndex].value;
	var b2winnerId = MatchWinnerUserIdMatch2.options[MatchWinnerUserIdMatch2.selectedIndex].value;

	var b1rpsId = RpsWinnerUserIdMatch1.options[RpsWinnerUserIdMatch1.selectedIndex].value;
	var b2rpsId = RpsWinnerUserIdMatch2.options[RpsWinnerUserIdMatch2.selectedIndex].value;

	var valid = true;

	//let's check all the values

	if(b1winnerId.length < 36) {

		valid = false
		$(MatchWinnerUserIdMatch1).parent().find("label").css({"color":"red"});
		
	}

	if(b2winnerId.length < 36) {

		valid = false
		$(MatchWinnerUserIdMatch2).parent().find("label").css({"color":"red"});
		
	}

	if(b1rpsId.length < 36) {

		valid = false
		$(RpsWinnerUserIdMatch1).parent().find("label").css({"color":"red"});
		
	}

	if(b2rpsId.length < 36) {

		valid = false
		$(RpsWinnerUserIdMatch2).parent().find("label").css({"color":"red"});
		
	}

	return valid;
	
}





</script>


	<div id='rules'>
		<div class='title'>
			RULES
		</div>
		<p>
			Use the form below to place your vote.
		</p>
		<p>
			Standard Points Will Be Applied:
			<ul>
				<li>Ro-Sham-Bo: 1 point</li>
				<li>Winner: 10 points</li>
				<li>Final Letters: 15 points</li>
			</ul>
		</p>
		<p style='font-size:18px; font-style:italic;'>
			An Additional Bonus of 200 Points will be given to whomever predicts the entire finals night with 100% accuracy! <br />
			This means that the overall points event is still up for grabs by anyone! <br />
			Vote Now! Finals Night is just a few days away!
		</p>
	</div>
<form method="post" action="/battle-at-the-berrics-4/confirm_vote" accept-charset="utf-8"><div style="display:none;"><input type="hidden" name="_method" value="POST" /></div>
	<div id='voting-form'>
		<table cellspacing='0' cellpadding='0' width='100%'>
		
			<tr>
			
				<th colspan='3'>Battle 1: <?php echo $match_1['Player1User']['first_name']; ?> <?php echo $match_1['Player1User']['last_name']; ?> VS. <?php echo $match_1['Player2User']['first_name']; ?> <?php echo $match_1['Player2User']['last_name']; ?></th>
			
			</tr>
			<tr id='match1'>
				<td>
					<?php 
					
						
						echo $this->Form->input("RpsWinnerUserIdMatch1",array("options"=>$match_1_list,"label"=>"Ro-Sham-Bo","name"=>"data[407][rps_winner_user_id]","empty"=>true));
					
					
					?>
				</td>
				<td>
				<?php 
					
						
						echo $this->Form->input("MatchWinnerUserIdMatch1",array("options"=>$match_1_list,"label"=>"Winner","name"=>"data[407][match_winner_user_id]","empty"=>true));
					
					
					?>
				</td>
				<td>
				<?php 
					
						
						echo $this->Form->input("WinnerFinalLettersMatch1",array("options"=>BatbMatch::winningLettersDrop(),"label"=>"Winners Final Letters","name"=>"data[407][winners_letters]"));
					
					
					?>
				</td>
			</tr>

		
			<tr>
			
				<th colspan='3'>Battle 2: <?php echo $match_2['Player1User']['first_name']; ?> <?php echo $match_2['Player1User']['last_name']; ?> VS. <?php echo $match_2['Player2User']['first_name']; ?> <?php echo $match_2['Player2User']['last_name']; ?></th>
			
			</tr>
			<tr id='match2'>
				<td>
					<?php 
					
						
						echo $this->Form->input("RpsWinnerUserIdMatch2",array("options"=>$match_2_list,"label"=>"Ro-Sham-Bo","name"=>"data[406][rps_winner_user_id]","empty"=>true));
					
					
					?>
				</td>
				<td>
				<?php 
					
						
						echo $this->Form->input("MatchWinnerUserIdMatch2",array("options"=>$match_2_list,"label"=>"Winner","name"=>"data[406][match_winner_user_id]","empty"=>true));
					
					
					?>
				</td>
				<td>
				<?php 
					
						
						echo $this->Form->input("WinnerFinalLettersMatch2",array("options"=>BatbMatch::winningLettersDrop(),"label"=>"Winners Final Letters","name"=>"data[406][winners_letters]"));
					
					
					?>
				</td>
			</tr>

		
			<tr>
			
				<th colspan='3'>Third Place Battle: <span id='third_place_player1'>?</span> VS. <span id='third_place_player2'>?</span></th>
			
			</tr>
				<tr>
				<td>
					<?php 
					
						
						echo $this->Form->input("RpsWinnerUserIdThird",array("options"=>array(),"label"=>"Ro-Sham-Bo","name"=>"data[409][rps_winner_user_id]","empty"=>true));
					
					
					?>
				</td>
				<td>
				<?php 
					
						
						echo $this->Form->input("MatchWinnerUserIdThird",array("options"=>array(),"label"=>"Winner","name"=>"data[409][match_winner_user_id]","empty"=>true));
					
					
					?>
				</td>
				<td>
				<?php 
					
						
						echo $this->Form->input("WinnerFinalLettersThird",array("options"=>BatbMatch::winningLettersDrop(),"label"=>"Winners Final Letters","name"=>"data[409][winners_letters]"));
					
					
					?>
				</td>
			</tr>
		
		
		

		
			<tr>
			
				<th colspan='3'>Championship Battle: <span id='finals_player1'>?</span> VS. <span id='finals_player2'>?</span></th>
			
			</tr>
				<tr>
				<td>
					<?php 
					
						
						echo $this->Form->input("RpsWinnerUserIdFinals",array("options"=>array(),"label"=>"Ro-Sham-Bo","name"=>"data[408][rps_winner_user_id]","empty"=>true));
					
					
					?>
				</td>
				<td>
				<?php 
					
						
						echo $this->Form->input("MatchWinnerUserIdFinals",array("options"=>array(),"label"=>"Winner","name"=>"data[408][match_winner_user_id]","empty"=>true));
					
					
					?>
				</td>
				<td>
				<?php 
					
						
						echo $this->Form->input("WinnerFinalLettersFinals",array("options"=>BatbMatch::winningLettersDrop(),"label"=>"Winners Final Letters","name"=>"data[408][winners_letters]"));
					
					
					?>
				</td>
			</tr>
		</table>
		<div id='submit-button-div'>
			<input type='button' value='Place Your Vote' id='submit-button'/>
		</div>
	</div>
	<input type='hidden' value='<?php echo $event['BatbEvent']['id']; ?>' name='data[batb_event_id]' />
</form>