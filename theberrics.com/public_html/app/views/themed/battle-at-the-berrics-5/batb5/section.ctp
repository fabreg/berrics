<?php 

$this->Html->css(array("section"),"stylesheet",array("inline"=>false));
$this->Html->script(array("section"),array("inline"=>false));

?>
<div id='batb5-bracket'>
	<div class='main-heading'></div>
	<div class='post'>
	
		<?php if(isset($posts) && count($posts)>0): ?>
			<?php foreach($posts as $post): ?>
				<div style='width:728px; margin:auto;'>
					<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
				</div>
				<div style='height:8px;'></div>
			<?php endforeach; ?>
		<?php endif; ?>
	
	</div>
	<div class='bracket-bg'>
		<div class='top-spacer'></div>
		<div id='bracket'>
			<?php foreach($event['Brackets'] as $bracket): ?>
				<?php 
				
					foreach($bracket as $match): 
					
					$player1_name = strtoupper($match['Player1User']['first_name'])." ".strtoupper($match['Player1User']['last_name']);
					$player2_name = strtoupper($match['Player2User']['first_name'])." ".strtoupper($match['Player2User']['last_name']);
					
					if(
						!empty($match['BatbMatch']['battle_dailyop_id']) || 
						!empty($match['BatbMatch']['pregame_dailyop_id']) || 
						!empty($match['BatbMatch']['postgame_dailyop_id'])
					) {
						
						$battle_link = "/battle-at-the-berrics-5/battle:".base64_encode($match['BatbMatch']['id'])."/".Tools::safeUrl(strtolower($player1_name)." vs ".strtolower($player2_name));
						
						$player1_name = "<a href='{$battle_link}'>".$player1_name."</a>";
						$player2_name = "<a href='{$battle_link}'>".$player2_name."</a>";
						
						
					}
					
				?>
				<div class='battle match_<?php echo $match['BatbMatch']['bracket_num']; ?>_<?php echo $match['BatbMatch']['match_num']; ?>'>
					<div class='player'>
						<?php echo $player1_name; ?>
					</div>
					<div class='spacer'></div>
					<div class='player'>
						<?php echo $player2_name; ?>
					</div>
				</div>
				<?php endforeach; ?>
			<?php endforeach; ?>
			<div id='downloads'>
				<strong>DOWNLOADS</strong>
				<div class='links'>
					<a href='http://static.theberrics.com/batb5/BATB5_RULES.pdf' target='_blank'>RULES</a> | <a href='http://static.theberrics.com/batb5/BATBV_bracket.pdf' target='_blank'>BRACKET</a>
				</div>
			</div>
		</div>
	</div>
	<div id='batb5-prediction-rules'>
		<div class='left-col'>
			<div class='rules'>
				
				<p>Place your prediction on the upcoming battles listed below.<br />
				Your prediction will be saved and your score will be calculated at the end of each battle.<br />
				Scoring is as follows:</p>
				<ul>
					<ul>- RO-SHAM-BO WINNER = 1 Point</ul>
					<ul>- BATTLE WINNER = 10 Points</ul>
					<ul>- WINNER'S FINAL LETTERS = 15 Points</ul>
				</ul>
				
				
			<p>
			Whomever has the highest weekly score will win a $25 Gift Certificate from LRG. <br />
			Whomever has the most points at the end of BATB V will win top secret prize package courtesy of LRG, <br /> a year's supply of DC Shoes, and an all expense paid trip to BATB VI Finals. <br />
			In the case of a tie, first place names will be entered and the winner will be randomly selected <br />
			</p>
			</div>
		</div>
		<div class='right-col'>
			<div id='lrg-300-250'>
				<script type="text/javascript">
				  var ord = window.ord || Math.floor(Math.random() * 1e16);
				  document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N5885/adj/batb5_dailyops;sz=300x250;ord=' + ord + '?"><\/script>');
				</script>
				<noscript>
				<a href="http://ad.doubleclick.net/N5885/jump/batb5_dailyops;sz=300x250;ord=[timestamp]?">
					<img src="http://ad.doubleclick.net/N5885/ad/batb5_dailyops;sz=300x250;ord=[timestamp]?" width="300" height="250" />
				</a>
				</noscript>
			</div>
		</div>
		<div style='clear:both;'></div>
	</div>
	<div id='batb5-voting'>
		<?php 
			echo $this->element("voting-box",array("match"=>$featured[0],"battle_number"=>1));
			echo $this->element("voting-box",array("match"=>$featured[1],"battle_number"=>2));
		?>
		<div style='clear:both;'></div>
	</div>
	<?php 
	
		if($this->Session->check("Auth.User.id")):
	
	?>
	<div class='user-credentials'>
		Signed in as: <?php echo $this->Session->read("Auth.User.email"); ?> <a href='/identity/login/logout/<?php echo base64_encode($this->here); ?>'>(Click Here To Sign Out)</a>
	</div>
	<?php 
	
		endif;	
	
	?>
	<div id='stats-summary'>
	
	
	</div>
	<div id='bottom-ads'>
		<script type="text/javascript">
		  var ord = window.ord || Math.floor(Math.random() * 1e16);
		  document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N5885/adj/batb5_dailyops_lo;sz=728x90;ord=' + ord + '?"><\/script>');
		</script>
		<noscript>
		<a href="http://ad.doubleclick.net/N5885/jump/batb5_dailyops_lo;sz=728x90;tile=1;ord=[timestamp]?">
		<img src="http://ad.doubleclick.net/N5885/ad/batb5_dailyops_lo;sz=728x90;tile=1;ord=[timestamp]?" width="728" height="90" />
		</a>
		</noscript>
	</div>
	<div style='height:20px;'></div>
	<div id='batb5-archive'>
		<?php //print_r($event); ?>
	</div>
</div>