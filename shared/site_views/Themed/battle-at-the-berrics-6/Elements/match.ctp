<?php

$player1 = ucfirst($match['Player1User']['first_name']).' '.ucfirst($match['Player1User']['last_name']);
$player2 = ucfirst($match['Player2User']['first_name']).' '.ucfirst($match['Player2User']['last_name']);

$link = '';

if(!empty($match['BatbMatch']['battle_dailyop_id']) || !empty($match['BatbMatch']['pregame_dailyop_id'])) {

	$enc = base64_encode($match['BatbMatch']['id']);

	$link = "/battle-at-the-berrics-6/battle:{$enc}/".Tools::safeUrl($player1." vs ".$player2);

	$player1 = "<a href='{$link}'>{$player1}</a>";
	$player2 = "<a href='{$link}'>{$player2}</a>";
}

?>
<div class="match">
	<div class="player player1">
		<?php echo $player1; ?>&nbsp;
	</div>
	<div class="mspacer"></div>
	<div class="player player2">
		<?php echo $player2; ?>&nbsp;
	</div>
</div>
<?php 

	//print_r($match);

 ?>