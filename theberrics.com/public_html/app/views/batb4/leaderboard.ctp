<?php

//die(pr($this->params));

$pos = 1;

$i = 1;

$this->Html->css("leaderboard/leaderboard","stylesheet",array("inline"=>false));

$this->set("right_column","");

?>
<div id='leaderboard-header'>
	<div class='tabs'>
		<ul>
			<li class='selected'><a href='/<?php echo $this->params['section']; ?>/leaderboard/overall'>Overall Scores</a></li>
			<li><a href='/<?php echo $this->params['section']; ?>/score/<?php echo $this->Session->read("Auth.User.id"); ?>'>My Profile</a></li>
		</ul>
	</div>
</div>

<table cellspacing='0' width='100%' class='lb-table'>
	<tr>
		<th>Rank</th>
		<th>Name</th>
		<th>Ro-Sham-Bo</th>
		<th>Winner</th>
		<th>Final Letters</th>
		<th>Total</th>
	</tr>
	<tbody>
	<?php 
		foreach($leaders as $k=>$v):
		
		if($this->params['pass'][0] != 'overall') {
			
			$v['BatbScore'] = $v;
			
			$v['BatbScore']['rps_score'] = $v[0]['rps_points'];
			$v['BatbScore']['match_score'] = $v[0]['match_points'];
			$v['BatbScore']['letters_score'] = $v[0]['letters_points'];
			
		}
		
	?>
	<tr>
		<td><?php echo $pos; ?></td>
		<td class='name'><a href='/battle-at-the-berrics-4/score/<?php echo $v['User']['id']; ?>'><?php echo $v['User']['first_name']." ".$v['User']['last_name']; ?></a></td>
		<td><?php echo $v['BatbScore']['rps_score']; ?></td>
		<td><?php echo $v['BatbScore']['match_score']; ?></td>
		<td><?php echo $v['BatbScore']['letters_score']; ?></td>
		<td><strong><?php echo $v[0]['total']; ?></strong></td>
	</tr>
	<?php 
	
		//lets check the final scores
		$next_score = $leaders[($k+1)][0]['total'];
		if($next_score < $v[0]['total']) {
			
			$pos ++;
			
		}
		endforeach;
	?>
	</tbody>
</table>