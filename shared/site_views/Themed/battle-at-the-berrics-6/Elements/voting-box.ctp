<?php 

$player_drop = array(

	$match['Player1User']['id'] => strtoupper($match['Player1User']['first_name'])." ".strtoupper($match['Player1User']['last_name']),
	$match['Player2User']['id'] => strtoupper($match['Player2User']['first_name'])." ".strtoupper($match['Player2User']['last_name'])

);

//letters
$letters_array = BatbMatch::winningLettersDrop();

?>
<div class="voting-box">
	<div class="voting-heading">
		UPCOMING BATTLE <?php echo $match_num; ?>
	</div>
	<div class="names">
		<div class="name">
			<div class="first">
				<?php echo strtoupper($match['Player1User']['first_name']); ?>
			</div>
			<div class="last">
				<?php echo strtoupper($match['Player1User']['last_name']); ?>
			</div>
		</div>
		<div class="name">
			<div class="first">
				<?php echo strtoupper($match['Player2User']['first_name']); ?>
			</div>
			<div class="last">
				<?php echo strtoupper($match['Player2User']['last_name']); ?>
			</div>
		</div>
	</div>
			<?php if(in_array(strtoupper(date("D")),array("MON","SAT","SUN"))):  ?>
			<div style='text-align:center; padding:5px;'>
				<button class='btn' disabled='disabled'>VOTING CLOSED</button>
			</div>
			<?php elseif($this->Session->check("Auth.User.id")): ?>
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
							<label>WINNERS LETTERS:</label> <?php echo $letters_array[$match['BatbVote']['winner_letters']]; ?>
						</div>
						<div class='tweet-button-div'>
							<?php 
								//lets construct the tweet text
								$winner = $user[$match['BatbVote']['match_winner_user_id']];
								$winner_handle = (!empty($winner['twitter_handle'])) ? $winner['twitter_handle']:strtoupper($winner['first_name'])." ".strtoupper($winner['last_name']);
								
								$loser_id = ($winner['id'] == $p1[0]['Player1User']['id']) ? $p2[0]['Player2User']['id']:$p1[0]['Player1User']['id'];
								$loser = $user[$loser_id];
								$loser_handle = (!empty($loser['twitter_handle'])) ? $loser['twitter_handle']:strtoupper($loser['first_name'])." ".strtoupper($loser['last_name']);
								
								$tweet_text = " BATBVI PREDICTION: {$winner_handle} over {$loser_handle}";
								
								switch($match['BatbMatch']['id']) {
									
									case 505:
										$tweet_text = "CHAMPIONSHIP PREDICTION: {$winner_handle} over {$loser_handle}";
									break;
									case 506:
										$tweet_text = "3rd PLACE PREDICTION: {$winner_handle} over {$loser_handle}";
										break;
								}
								
								$tq = array(
										"original_referer"=>"http://theberrics.com/battle-at-the-berrics-6",
										"source"=>"tweetbutton",
										"text"=>$tweet_text,
										"via"=>"berrics",
										"hashtags"=>"BATB"
									);
							
							?>
							<a href='https://twitter.com/intent/tweet?<?php echo http_build_query($tq); ?>' target='_blank' class='btn'>
								TWEET YOUR VOTE
							</a>
						</div>
				<?php else: ?>
					<?php 					
						echo $this->Form->create("BatbVote",array("url"=>$this->here,"id"=>"voting-box-form"));
						echo $this->Form->input("batb_match_id",array("type"=>"hidden","value"=>$match['BatbMatch']['id']));
						echo $this->Form->input("rps_winner_user_id",array("options"=>$player_drop,"label"=>"RO-SHAM-BO","empty"=>true));
						echo $this->Form->input("match_winner_user_id",array("options"=>$player_drop,"label"=>"WINNER","empty"=>true));
						echo $this->Form->input("winner_letters",array("options"=>BatbMatch::winningLettersDrop(),"label"=>"WINNERS LETTERS"));
					?>
					<div class="submit-div">
						<?php echo $this->Form->submit("SUBMIT PREDICTION",array("class"=>"btn")); ?>
					</div>
					<?php
						echo $this->Form->end();
					?>
				<?php endif;?>
			<?php else: ?>
				<div class='fb-button-div'>
					<a href='javascript:openUserLogin("/identity/login/form/<?php echo base64_encode($this->here); ?>");' class='btn'>
						SIGN INTO THE BERRICS TO VOTE
					</a>
				</div>
			<?php endif; ?>
</div>
<?php pr($match); ?>