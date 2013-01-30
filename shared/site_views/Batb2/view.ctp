<?php
$this->Html->css("batb2","stylesheet",array("inline"=>false));

$winner = $users[$event['BatbEvent']['first_place_user_id']];
$second = $users[$event['BatbEvent']['second_place_user_id']];
$third = $users[$event['BatbEvent']['thrid_place_user_id']];

?>


<div id='batb-view'>

	<div class="header">
 			<img src="/img/layout/batb2/batb2banhead02.jpg"/>
		</div>

<div id="winner"><?php echo $winner['first_name'].' '.$winner['last_name'];?> </div>
<div id="third">Third Place</div>		
		
	<div id='brackets'>
		<?php 
		
		
				foreach($event['Brackets'] as $bracket) {
			
					foreach($bracket as $match) {
						
						echo $this->element("batb/batb_match",array("match"=>$match,"users"=>$users));
						
					}
					
				}
			
		
		?>
	</div>
	
</div>
