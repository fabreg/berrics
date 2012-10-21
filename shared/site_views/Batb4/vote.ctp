<?php 


$this->set("title_for_layout","Finals Night Voting");


//make list of match 1 and match 2

$match_1_list = array(

	$match_1['Player1User']['id']=>$match_1['Player1User']['first_name']." ".$match_1['Player1User']['last_name'],
	$match_1['Player2User']['id']=>$match_1['Player2User']['first_name']." ".$match_1['Player2User']['last_name']

);

$match_2_list = array(

	$match_2['Player1User']['id']=>$match_2['Player1User']['first_name']." ".$match_2['Player1User']['last_name'],
	$match_2['Player2User']['id']=>$match_2['Player2User']['first_name']." ".$match_2['Player2User']['last_name']

);



?>
<style>

</style>
<script>
$(document).ready(function() { 

	
	
});
</script>
<div id='batb4-vote'>

	<div id='rules'>
		<div class='title'>
			STRATEGIC PREDICTIONS: FINALS NIGHT
		</div>
		Here are some rules that you must follow
	</div>

	<div id='voting-form'>
		<table cellspacing='0' cellpadding='0' width='100%'>
		
			<tr>
			
				<th colspan='3'>Battle 1: <?php echo $match_1['Player1User']['first_name']; ?> <?php echo $match_1['Player1User']['last_name']; ?> VS. <?php echo $match_1['Player2User']['first_name']; ?> <?php echo $match_1['Player2User']['last_name']; ?></th>
			
			<tr>
			<tr>
				<td>
					<?php 
					
						
						echo $this->Form->input("RoShamBoMatch1",array("options"=>$match_1_list,"label"=>"Ro-Sham-Bo"));
					
					
					?>
				</td>
				<td></td>
				<td></td>
			</tr>
		</table>
		
		<table cellspacing='0' cellpadding='0' width='100%'>
		
			<tr>
			
				<th>Battle 2: <?php echo $match_2['Player1User']['first_name']; ?> <?php echo $match_2['Player1User']['last_name']; ?> VS. <?php echo $match_2['Player2User']['first_name']; ?> <?php echo $match_2['Player2User']['last_name']; ?></th>
			
			<tr>
			
		</table>
		
		
		<table cellspacing='0' cellpadding='0' width='100%'>
		
			<tr>
			
				<th>Third Place Match: MikeMo Capaldi VS. Morgan Smith</th>
			
			<tr>
		
		</table>
		
		
		<table cellspacing='0' cellpadding='0' width='100%'>
		
			<tr>
			
				<th>Vote 1: MikeMo Capaldi VS. Morgan Smith</th>
			
			<tr>
		
		</table>
	</div>
</div>