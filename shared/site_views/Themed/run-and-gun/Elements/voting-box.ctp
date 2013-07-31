<?php 

$nums = array();

for($i=1.0;$i<=10;($i = number_format(($i+.1),1))) {

	if($i>=10) $i = 10;

	if($i == 1) $i = "1.0";

	$nums[$i] = $i;

}


?>
<div class="vote-box">
	<div class="select-menu">
		<?php echo $this->Form->create('RgVote',array(
			"id"=>'RgVoteForm',
			"url"=>$this->request->here
		)); 

		echo $this->Form->input("dailyop_id",array("type"=>"hidden","value"=>$post_id));
		?>
		<?php echo $this->Form->select("score",$nums,array("id"=>"score-drop-{$num}","empty"=>false)) ?>
		<?php echo $this->Form->end(); ?>
	</div>
</div>

