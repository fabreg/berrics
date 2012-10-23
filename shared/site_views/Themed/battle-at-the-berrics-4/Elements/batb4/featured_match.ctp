<?php 


$player1 = $users[$match['BatbMatch']['player1_user_id']];
$player2 = $users[$match['BatbMatch']['player2_user_id']];

?>
<div class='featured-match'>
	<div class='player1'>
		
		<div class='flag'>
			<img src='/theme/battle-at-the-berrics-4/img/flags/<?php echo strtolower($player1['country']); ?>.png' />
		</div>
		<?php echo strtoupper($player1['first_name']." ".$player1['last_name']); ?>
	</div>
	<div class='player2'>

		<?php echo strtoupper($player2['first_name']." ".$player2['last_name']); ?>
				<div class='flag'>
			<img src='/theme/battle-at-the-berrics-4/img/flags/<?php echo strtolower($player2['country']); ?>.png' />
		</div>
	</div>
	<div class='vote-button'>
		<!-- <?php if(empty($match['BatbMatch']['legacy_video_link'])) { ?>
		<a href='/voting/place_vote/battle-at-the-berrics-4.html'>
			<img src='/theme/battle-at-the-berrics-4/img/layout/predict-button.jpg' border='0' />
		</a>
		<?php } else { ?>
		<a href='<?php echo $match['BatbMatch']['legacy_video_link']; ?>' target='_blank'>
			<img src='/theme/battle-at-the-berrics-4/img/layout/watch-button.jpg' border='0' />
		</a>
		
		<?php } ?>-->
	</div>
</div>