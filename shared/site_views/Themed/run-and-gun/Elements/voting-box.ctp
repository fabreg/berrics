<?php 

$nums = array();

for($i=1.0;$i<=10;($i = number_format(($i+.1),1))) {

	if($i>=10) $i = 10;

	if($i == 1) $i = 1.0;

	$nums[$i] = $i;

}


?>
<div class="vote-box">
	<div class="select-menu">
		<?php echo $this->Form->select("score_drop",$nums,array("id"=>"score-drop","empty"=>false)) ?>
	</div>
</div>

