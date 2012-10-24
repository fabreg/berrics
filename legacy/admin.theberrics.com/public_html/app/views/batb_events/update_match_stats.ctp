<?php

$rps = array(
	
	"rock"=>"Rock",
	"paper"=>"Paper",
	"scissors"=>"Scissors"

);

?>
<div class='form'>
<h2>Update Battle Stats</h2>
<div class='actions' style='font-size:130%; font-weight:bold; padding:5px;'>
<?php echo $this->Html->link("<< Go Back To The Brackets",array("action"=>"view",$match['BatbMatch']['batb_event_id'])); ?>
</div>
<div class='actions' style='font-size:130%; font-weight:bold;  padding:5px;'>
<?php echo $this->Html->link("Watch The Battle",$match['BatbMatch']['legacy_video_link'],array("target"=>"_blank")); ?>
</div>
<?php 

	echo $this->Form->create("BatbMatch",array("url"=>$this->here));
?>
<fieldset>
	<legend>Player 1: <?php echo $match['Player1User']['first_name']; ?> <?php echo $match['Player1User']['last_name']; ?></legend>
	<?php 
	
		echo $this->Form->input("player1_trick_miss");
		echo $this->Form->input("player1_trick_land");
		echo $this->Form->input("player1_ro_sham_bo",array("options"=>$rps));
	
	?>
</fieldset>
<fieldset>
	<legend>Player 2: <?php echo $match['Player2User']['first_name']; ?> <?php echo $match['Player2User']['last_name']; ?></legend>
	<?php 
	
			echo $this->Form->input("player2_trick_miss");
		echo $this->Form->input("player2_trick_land");
		echo $this->Form->input("player2_ro_sham_bo",array("options"=>$rps));
	
	?>
</fieldset>

<?php 
	echo $this->Form->input("id");
	echo $this->Form->end("Update Stats");


?>
</div>