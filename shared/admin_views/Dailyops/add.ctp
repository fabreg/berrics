<?php 

$sort = array();

for($i=1;$i<=5;$i++) $sort[$i] = $i;

?>
<script>

$(document).ready(function() { 

	$( "#DailyopPubDate").datepicker({
		"dateFormat":"yy-mm-dd"
	});

	$("#DailyopPubTime").timepicker({
	    showPeriod: false,
	    showLeadingZero: false
	});
	
});
</script>
<div class="dailyops form">
<?php echo $this->Form->create('Dailyop');?>
	<fieldset>
 		<legend>New Dailyop's Post</legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input("sub_title");
		echo $this->Form->input('dailyop_section_id');
		echo $this->Form->input("pub_date");
		echo $this->Form->input("pub_time");
		echo $this->Form->input("UserAssignedPosts.user_id",array("options"=>$users,"multiple"=>true));
	?>
	</fieldset>
	<fieldset>
		<legend>
			Stage Blank Media Files
		</legend>
		<div class='well'>
			<?php 
				echo $this->Form->input("num_videos",array("options"=>$sort,"empty"=>true,"label"=>"Video Files"));
			?>
		</div>
	</fieldset>
<?php echo $this->Form->end("Next >");?>
</div>
