<?php 

//remove the right column

$this->set("right_column","");

$this->Html->css("view_finals","stylesheet",array("inline"=>false));
$this->Html->script(array("view","dailyops/post-bit"),array("inline"=>false));

$winner = $users[$event['BatbEvent']['first_place_user_id']];
$second = $users[$event['BatbEvent']['second_place_user_id']];
$third = $users[$event['BatbEvent']['thrid_place_user_id']];


$this->set("title_for_layout","Battle At The Berrics 4: U.S. VS THEM");


?>
<style>

</style>	

<script>
$(document).ready(function() { 



	if(document.location.href.match(/(.html|view:)/)) {

		$(window).scrollTo("1200");
		
	}

	$('.batb-match-thumb').hover(

		function() { 

			$(this).append("<div class='over'></div>");
			$(this).find('.over').fadeIn();
		},
		function() { 

			$(this).find(".over").remove();

		}

	).click(function() { 

		var ref = $(this).find("a").attr("href");


		document.location.href = ref;
		
	});

	
});

</script>

		
<div id='batb4'>
	<div id='batb4-header'>
		<div class='lrg-link'>
			<a href='http://l-r-g.com/skate/' target='_blank'>
				<img src='/theme/battle-at-the-berrics-4/img/px.gif' border='0' height='134' width='110' />
			</a>
		</div>
	</div>
	<div id='brackets'>
		<?php 
	
			foreach($event['Brackets'] as $bracket) {
				
				foreach($bracket as $matches) {
					
					echo $this->element("batb4/batb_match",array("match"=>$matches,"users"=>$users));
					
				}
				
			}

		?>
	</div>
	
	<div id='current-battles'>
		<div class='links'>
			<a href='/battle-at-the-berrics-4/leaderboard'>Leaderboard</a>
		</div>
		<div class='spacer'></div>
		<div class='left'>
		
			<?php 
			
				if(!empty($featured_matches[0])) {
					
					echo $this->element("batb4/featured_match",array("match"=>$featured_matches[0],"users"=>$users));
					
				}
			
			?>
		
		</div>
		<div class='right'>
		
			<?php 
			
				if(!empty($featured_matches[1])) {
					
					echo $this->element("batb4/featured_match",array("match"=>$featured_matches[1],"users"=>$users));
					
				}
			
			?>
		
		</div>
		<div style="clear:both;"></div>
	</div>

</div>

<div id='posts' style='width:728px; margin:auto; padding-top:20px;'>
		<?php 
	

			if(isset($post)) {

				echo $this->element("dailyops/post-bit",array("dop"=>$post));
				
			}
	
		?>
		
		<?php 
		
		
			if(isset($match)) {
				
				//pregame
				if(isset($match['PreGamePost']['Dailyop']['id'])) {
					
					echo $this->element("dailyops/post-bit",array("dop"=>$match['PreGamePost']));
					echo "<div style='height:15px;'></div>";
					
				}
				
				
				//battle
				
				if(isset($match['BattlePost']['Dailyop']['id'])) {
					
					
					echo $this->element("dailyops/post-bit",array("dop"=>$match['BattlePost']));
					echo "<div style='height:15px;'></div>";
					
				}
				
				//post game
				
				if(isset($match['PostGamePost']['Dailyop']['id'])) {
					
					
					echo $this->element("dailyops/post-bit",array("dop"=>$match['PostGamePost']));
					
				}
				
				
				
			}
		
		
		?>
		
</div>
<div id='batb-rounds'>
	<?php 
		$total_rounds = BatbMatch::totalBrackets($event['BatbEvent']['num_players']);
		
		$flipped = array_reverse($event['Brackets'],true);
		
		foreach($flipped as $round=>$bracket):
			//check to see if we have at lease one battle video
			
			$check = Set::extract("/BattlePost/Dailyop/id[text=/[0-9a-zA-Z\-]/]",$bracket);
			if(count($check)<=0) {
				
				continue;
				
			}
			
	?>
	
		<div class='round-title'>Round <?php echo ($total_rounds - $round)+1;?></div>
			
				<?php 
				
					foreach($bracket as $match):

						if(isset($match['BattlePost']['Dailyop']['id'])):
						$p1 = $users[$match['BatbMatch']['player1_user_id']];
						$p2 = $users[$match['BatbMatch']['player2_user_id']];
						$link = Tools::safeUrl($p1['first_name']." ".$p1['last_name']." VS ".$p2['first_name']." ".$p2['last_name']);
						
				?>
					<div class='batb-match-thumb'>
						
						<?php 
						$thumb = $this->Media->mediaThumb(array(
						
							"MediaFile"=>$match['BattlePost']['DailyopMediaItem'][0]['MediaFile'],
							"w"=>200
						
						)); 
						echo "<a href='/battle-at-the-berrics-4/view:{$link}'>{$thumb}</a>";
						?>
					
					</div>		
							
				<?php				
						endif;	
					
					
					endforeach;
		
				?>
		<div style='clear:both;'></div>
	<?php 
	
		endforeach;
	
	?>
</div>