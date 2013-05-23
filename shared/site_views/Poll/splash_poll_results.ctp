<?php

function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}

?>
<style>
.result-heading {

	position: absolute;
	top:0px;
	left:5px;
	height:100%;
	z-index: 101;
	font-size: 24px;
	color:#fff;
	line-height: 40px;
	font-family: 'universcnb';
}
.result-bar {

	height:35px;
	position: relative;
	width:100%;
	margin-bottom: 10px;
}

.result-bar-inner {

	position: absolute;
	z-index: 100;
	top:0px;
	left:0px;
	height:100%;
}
</style>
<div class="poll-heading">
	<h1>POLL RESULTS</h1>
</div>
<div id="poll-description">
	<?php echo $poll['Poll']['description']; ?>
</div>
<div id="poll-results">
	<?php foreach ($results as $k => $v): 

		if(!isset($v[0]['percent'])) continue;

	?>
	<div class="result-row">
		
		<div class="result-bar" >
			<div class="result-heading">
				<?php echo $v['PollVotingOption']['name']; ?> - <?php echo $v[0]['percent']; ?>%
			</div>
			<div style='background-color:#<?php echo random_color(); ?>; width:<?php echo ceil($v[0]['percent']); ?>%; ' class="result-bar-inner">
				
			</div>
		</div>
	</div>
	<?php endforeach ?>
</div>