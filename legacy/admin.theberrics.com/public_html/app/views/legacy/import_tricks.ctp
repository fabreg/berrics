<div class='form'>
<?php 

	foreach($tricks as $t):

?>

	<?php 
		echo "<div>";
		echo $this->Form->create("MediaFile",array("url"=>array("controller"=>"legacy","action"=>"ajax_insert_trick")));
		echo $this->Form->input("name",array("value"=>$t['trickname']." - ".$t['personname']));
		echo $this->Form->input("tags");
		echo $this->Form->input("brightcove_id",array("value"=>$t['bcove_video'],"type"=>"text"));
		echo $this->Form->input("media_type",array("value"=>"bcove"));
		echo $this->Form->end("Insert Trick");
		echo "</div>";
	?>

<?php 

	endforeach;

?>
</div>