<?php 

$player_drop = array(

	$match['Player1User']['id'] => strtoupper($match['Player1User']['first_name'])." ".strtoupper($match['Player1User']['last_name']),
	$match['Player2User']['id'] => strtoupper($match['Player2User']['first_name'])." ".strtoupper($match['Player2User']['last_name'])

);


?>
<div class='voting-box'>
	<div class='heading'>BATTLE <?php echo $battle_number; ?></div>
	<div class='inner'>
		<div class='name'>
			<?php echo strtoupper($match['Player1User']['first_name']); ?><br /><?php echo strtoupper($match['Player1User']['last_name']); ?>
		</div>
		<div class='name'>
			<?php echo strtoupper($match['Player2User']['first_name']); ?><br /><?php echo strtoupper($match['Player2User']['last_name']); ?>
		</div>
		<div class='vs'>VS</div>
	</div>
	<div style='clear:both;'></div>
	<div class='voting-form'>
		<div class='vote-heading'>PREDICTION</div>
		<?php if($this->Session->check("Auth.User.id")): ?>
			<?php if(isset($match['BatbVote']['id'])): ?>
					<?php 
					
						$p1 = Set::extract("/Player1User",$match);
						$p2 = Set::extract("/Player2User",$match);
						
						$user[$p1[0]['Player1User']['id']] = $p1[0]['Player1User'];
						$user[$p2[0]['Player2User']['id']] = $p2[0]['Player2User'];
						
						
						
					?>
					<div class='result-heading'>
						YOUR VOTE HAS BEEN ACCEPTED
					</div>
					<div class='result'>
						<label>RO-SHAM-BO:</label> <?php echo strtoupper($user[$match['BatbVote']['rps_winner_user_id']]['first_name']); ?> <?php echo strtoupper($user[$match['BatbVote']['rps_winner_user_id']]['last_name']); ?>
					</div>
					<div class='result'>
						<label>MATCH WINNER:</label> <?php echo strtoupper($user[$match['BatbVote']['match_winner_user_id']]['first_name']); ?> <?php echo strtoupper($user[$match['BatbVote']['match_winner_user_id']]['last_name']); ?>
					</div>
					<div class='result'>
						<label>WINNERS LETTERS:</label> <?php echo $match['BatbVote']['winner_letters']; ?>
					</div>
			<?php else: ?>
				<?php 
				
					echo $this->Form->create("BatbVote",array("url"=>$this->here));
					echo $this->Form->input("batb_match_id",array("type"=>"hidden","value"=>$match['BatbMatch']['id']));
					echo $this->Form->input("rps_winner_user_id",array("options"=>$player_drop,"label"=>"RO-SHAM-BO","empty"=>true));
					echo $this->Form->input("match_winner_user_id",array("options"=>$player_drop,"label"=>"WINNER","empty"=>true));
					echo $this->Form->input("winner_letters",array("options"=>BatbMatch::winningLettersDrop(),"label"=>"WINNERS LETTERS"));
					echo $this->Form->end("SUBMIT PREDICTION");
				
				?>
			<?php endif;?>
		<?php else: ?>
			<div class='fb-button-div'>
				<a href='/identity/login/send_to_facebook/<?php echo base64_encode($this->here); ?>'>
					CONNECT TO FACEBOOK
				</a>
			</div>
		<?php endif; ?>
	</div>
</div>