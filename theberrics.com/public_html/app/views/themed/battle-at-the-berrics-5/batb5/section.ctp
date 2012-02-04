<?php 

$this->Html->css(array("section"),"stylesheet",array("inline"=>false))


?>
<div id='batb5-bracket'>
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
	<div id='batb5-prediction-rules'>
		Rules
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