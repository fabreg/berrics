<?php 

$player_drop = array(

	$match['Player1User']['id'] => strtoupper($match['Player1User']['first_name'])." ".strtoupper($match['Player1User']['last_name']),
	$match['Player2User']['id'] => strtoupper($match['Player2User']['first_name'])." ".strtoupper($match['Player2User']['last_name'])

);

//letters
$letters_array = BatbMatch::winningLettersDrop();

?>
<div class='voting-box'>
	<div class='heading'><img src='/theme/battle-at-the-berrics-5/img/battle<?php echo $battle_number; ?>-heading.jpg' border='0' /></div>
	<div class='inner'>
		<div class='name-wrapper'>
			<div class='name'>
				<?php echo strtoupper($match['Player1User']['first_name']); ?><br /><strong><?php echo strtoupper($match['Player1User']['last_name']); ?></strong>
			</div>
			<div class='name'>
				<?php echo strtoupper($match['Player2User']['first_name']); ?><br /><strong><?php echo strtoupper($match['Player2User']['last_name']); ?></strong>
			</div>
			<div style='clear:both;'></div>
		</div>
		
		<div class='voting-form'>
			<div class='vote-heading'>YOUR PREDICTION</div>
			<?php if(in_array(strtoupper(date("D")),array("SAT","SUN","MON"))): ?>
			<div style='text-align:center; padding:5px;'>
				<img border='0' src='/theme/battle-at-the-berrics-5/img/submissions-closed.jpg'/>
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
								
								$tweet_text = " BATBV PREDICTION: {$winner_handle} over {$loser_handle}";
								
								$tq = array(
										"original_referer"=>"http://theberrics.com/battle-at-the-berrics-5",
										"source"=>"tweetbutton",
										"text"=>$tweet_text,
										"via"=>"berrics",
										"hashtags"=>"BATB"
									);
							
							?>
							<a href='https://twitter.com/intent/tweet?<?php echo http_build_query($tq); ?>' target='_blank'>
								<img src='/theme/battle-at-the-berrics-5/img/tweet-button.jpg' border='0'/>
							</a>
						</div>
				<?php else: ?>
					<?php 					
						echo $this->Form->create("BatbVote",array("url"=>$this->here,"id"=>"voting-box-form"));
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
						<img border='0' src='/theme/battle-at-the-berrics-5/img/fb-connect.png' alt='Connect to the berrics via facebook' />
					</a>
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<!-- 
<a href="https://twitter.com/intent/tweet?original_referer=http%3A%2F%2Ftheberrics.com%2Fdailyops&amp;source=tweetbutton&amp;text=SHOOT%20ALL%20SKATERS%20RB%20Umali%20Part%201&amp;url=http%3A%2F%2Ftheberrics.com%2Fshoot-all-skaters%2Frb-umali-part-1.html&amp;via=berrics" class="btn" id="b" target="_blank"><i></i><span class="label" id="l">Tweet</span></a>
-->