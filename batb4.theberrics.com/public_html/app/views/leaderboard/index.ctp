<?php

//die(pr($this->params));

$pos = 1;

$i = 1;

$this->Html->css("leaderboard/index","stylesheet",array("inline"=>false));

?>
<div id='leaderboard-header'>
	<div class='tabs'>
		<ul>
			<li <?php echo ($this->params['pass'][0]!='overall') ? "class='selected'":""; ?>><?php echo $this->Html->link("Weekend Scores",array("controller"=>"leaderboard","action"=>"index")); ?></li>
			<li <?php echo ($this->params['pass'][0]=='overall') ? "class='selected'":""; ?>><?php echo $this->Html->link("Overall Scores",array("controller"=>"leaderboard","action"=>"index","overall")); ?></li>
			<li><?php echo $this->Html->link("My Profile",array("controller"=>"leaderboard","action"=>"score",$this->Session->read("Auth.User.id"))); ?></li>
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
		<td class='name'><?php echo $this->Html->link($v['User']['first_name']." ".$v['User']['last_name'],array("controller"=>"leaderboard","action"=>"score",$v['User']['id'])); ?></td>
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