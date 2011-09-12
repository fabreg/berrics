<?php 

$this->Html->css("home/index","stylesheet",array("inline"=>false));
$this->Html->script(array("index"),array("inline"=>false));

$winner = $users[$event['BatbEvent']['first_place_user_id']];
$second = $users[$event['BatbEvent']['second_place_user_id']];
$third = $users[$event['BatbEvent']['thrid_place_user_id']]
?>				<!-- 
				<div id='dc-header'>
					<div class='banner'>

					<script type="text/javascript" src="http://gdfp.g.doubleclick.net/N5885/adj/BATB4/;sz=728x90;ord=[timestamp]?"></script>
					</div>
				</div>
				 -->
				<div id='batb4-header'>
					<div class='lrg-link'>
						<a href='http://l-r-g.com/skate/' target='_blank'>
							<img src='/img/px.gif' border='0' height='134' width='110' />
						</a>
					</div>
				</div>
<div id='brackets'>
	<?php 

		foreach($event['Brackets'] as $bracket) {
			
			foreach($bracket as $match) {
				
				echo $this->element("batb_match",array("match"=>$match,"users"=>$users));
				
			}
			
		}
	
		
	?>
</div>

<div id='current-battles'>
	<div class='links'>
		<?php echo $this->Html->link("View Leaderboard",array("controller"=>"leaderboard")); ?>
	</div>
	<div class='spacer'></div>
	<div class='left'>
	
		<?php 
		
			if(!empty($featured_matches[0])) {
				
				echo $this->element("featured_match",array("match"=>$featured_matches[0],"users"=>$users));
				
			}
		
		?>
	
	</div>
	<div class='right'>
	
		<?php 
		
			if(!empty($featured_matches[1])) {
				
				echo $this->element("featured_match",array("match"=>$featured_matches[1],"users"=>$users));
				
			}
		
		?>
	
	</div>
	<div style="clear:both;"></div>
</div>


<?php 

pr($this->Session->read());

?>


<?php

//pr($users);
//pr($event);

?>