<?php 

$this->Html->css(array("section"),"stylesheet",array("inline"=>false))


?>
<div id='batb5-bracket'>
	<div class='main-heading'></div>
	<div class='post'></div>
	<div class='bracket-bg'>
		<div class='top-spacer'></div>
		<div id='bracket'>
			<?php foreach($event['Brackets'] as $bracket): ?>
				<?php foreach($bracket as $match): ?>
				<div class='battle match_<?php echo $match['BatbMatch']['bracket_num']; ?>_<?php echo $match['BatbMatch']['match_num']; ?>'>
					<div class='player'>
						<?php echo strtoupper($match['Player1User']['first_name']); ?> <?php echo strtoupper($match['Player1User']['last_name']); ?>
					</div>
					<div class='spacer'></div>
					<div class='player'>
						<?php echo strtoupper($match['Player2User']['first_name']); ?> <?php echo strtoupper($match['Player2User']['last_name']); ?>
					</div>
				</div>
				<?php endforeach; ?>
			<?php endforeach; ?>
		</div>
	</div>
	<div id='batb5-prediction-rules'>
		<div class='left-col'>
			<div class='rules'>
				Place your prediction on the upcoming battles listed below.<br />
				Your prediction will be saved and your score will be calculated at the end of each battle.<br />
							- Scoring is as follows...
				- RO-SHAM-BO WINNER = 1 Point
				- BATTLE WINNER = 10 Points
				- WINNER'S FINAL LETTERS = 15 Points
			- Whomever has the highest weekly score will win a $25 Gift Certificate from LRG. 
			- Whomever has the most points at the end of BATB IV will win top secret prize package courtesy of LRG,
			  a year's supply of DC Shoes, and all expense paid trip to BATB VI Finals.. 
			- In the case of a tie, first place names will be entered and winner will be randomly selected
			</div>
		</div>
		<div class='right-col'>
			
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
	<?php if(empty($profile['UserProfile']['shoe_size']) || empty($profile['UserProfile']['shirt_size'])): ?>
	<div id='batbox-form'>
		BATBOX GIVEAWAY
	</div>
	<?php endif; ?>
	<div id='stats-summary'>
	
	
	</div>
	<pre>
	<?php	
	
		print_r($featured);
	
	?>
	</pre>
</div>