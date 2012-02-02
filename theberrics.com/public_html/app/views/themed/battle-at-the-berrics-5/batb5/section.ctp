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
		<div>
			Voting Box 1
		</div>
		<div>
			Voting Box 2
		</div>
	</div>
	<pre>
	<?php	
	
		print_r($event);
	
	?>
	</pre>
</div>