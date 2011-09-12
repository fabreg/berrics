<?php 

$this->Html->css("leaderboard/score","stylesheet",array("inline"=>false));

?>
<div id='profile-header'>
	<div class='links'>
		<?php echo $this->Html->link("VIEW LEADERBOARD",array("controller"=>"leaderboard","action"=>"index")); ?>
	</div>
</div>
<div id='score'>
<div class='left' style='width:99%; margin:auto;'>
	<div id='user-profile'>
		<img src='http://graph.facebook.com/<?php echo $user['User']['facebook_account_num']; ?>/picture' class='profile-image'/>
		<div class='name'><?php echo $user['User']['first_name']; ?> <?php echo $user['User']['last_name']; ?></div>
		<div><?php echo $this->Html->link("Visit ".$user['User']['first_name']." on Facebook","http://www.facebook.com/profile.php?id=".$user['User']['facebook_account_num'],array("target"=>"_blank")); ?></div>
		<div style='clear:both;'></div>
		<div class='rank'>Overall Rank: # <?php echo ($score['BatbScore']['rank_number'] == NULL) ? "?":$score['BatbScore']['rank_number']; ?></div>
	</div>
	<div id='total'>
		<div class='score-header'>SCORE:</div>
		<table cellspacing='0'>
			<tr>
				<td>Ro-Sham-Bo</td>
				<td class='total'><?php echo $score['BatbScore']['rps_score']; ?></td>
			</tr>
			<tr>
				<td>Winner</td>
				<td class='total'><?php echo $score['BatbScore']['match_score']; ?></td>
			</tr>
			<tr>
				<td>Final Letters</td>
				<td class='total'><?php echo $score['BatbScore']['letters_score']; ?></td>
			</tr>
			<tr class='total-row'>
				<td class='total-cell'>Total</td>
				<td class='total'><?php echo ($score['BatbScore']['letters_score'] + $score['BatbScore']['match_score'] + $score['BatbScore']['rps_score']); ?></td>
			</tr>
		</table>
	</div>
</div>
<!-- 
<div class='right'>
<script type="text/javascript" src="http://gdfp.g.doubleclick.net/N5885/adj/BATB4SP/;sz=300x250;ord=[timestamp]?"></script>

</div>
 -->

<div style='clear:both;'></div>
</div>
<div id='votes'>
<div class='voting-header'>
	
</div>
<?php 
foreach($votes as $vote):
?>
<div>
<?php

	echo $this->element("vote",array("vote"=>$vote));

?>
</div>
<?php 
endforeach;
?>
<?php 
pr($votes);
?>
</div>