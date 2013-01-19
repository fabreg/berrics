<?php 

$title_for_layout = "Battle At The Berrics 6 - Presented by DC Shoes & LRG Clothing";
$this->set(compact("title_for_layout"));

?>
<script type="text/javascript">
	
	jQuery(document).ready(function($) {
		
		var meta = $("meta[name=viewport]");

		meta.attr({

			"content":"width=1300px, initial-scale=0"

		});


		//handle the form submit
		$('.voting-div form').submit(function() { 

				//validate the vote
				var winner_select = $(this).find("select[name='data[BatbVote][match_winner_user_id]']");
				var ro_sham_bo_select = $(this).find("select[name='data[BatbVote][rps_winner_user_id]']");
				var letters_select = $(this).find("select[name='data[BatbVote][winner_letters]']");
				
				if($(ro_sham_bo_select).val().length<=0 || $(winner_select).val().length<=0) {
					
					alert("Hey! You forgot something!");
					return false;
					
				}
				
				//we're all good, now allow the user to confirm their vote
				var str = "Confirm your prediction: \n";
				str += "Ro-Sham-Bo: "+$(ro_sham_bo_select).find("option:selected").text()+"\n";
				str += "Winner: "+$(winner_select).find("option:selected").text()+" with "+$(letters_select).find("option:selected").text();
				
				return confirm(str);

				return false;

		});
	
		loadScores("overall");
		loadScores("weekly");

	});

	function loadScores ($type) {
		
		var type = $type || "weekly";

		var ele = $('.scores .'+type);

		ele.html("<div class='alert'>Loading .... </div>");

		ele.load("/battle-at-the-berrics-6/ajax_leaderboard/"+type);

	}
	
</script>
<div class="top-header clearfix">
	<div class='top-dc-flag'>
		<img src="/theme/battle-at-the-berrics-6/img/dc-top-flag.jpg" alt="DC Shoes" />
	</div>
	<div class="top-banner">
		<script type="text/javascript">
		  var ord = window.ord || Math.floor(Math.random() * 1e16);
		  document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N5885/adj/batb5_dailyops_lo;sz=728x90;ord=' + ord + '?"><\/script>');
		</script>
		
	</div>
	<div class="top-lrg-logo">
		<img src="/theme/battle-at-the-berrics-6/img/lrg-top-logo.png" alt="LRG Clothing" />
	</div>
</div>
<div class="main-logo">
	<img src="/theme/battle-at-the-berrics-6/img/batb6-top-logo.png" alt="" />
</div>
<div class="post-view">
	<?php if (count($posts)>0): ?>
		 <?php foreach ($posts as $k => $post): ?>
		 	<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)) ?>
		 <?php endforeach ?>
	<?php endif; ?>
</div>
<div class="bracket-div">
	<div class="shim"></div>
	<div class="bracket">
		<!-- Bracket 5 -->
		<div class="col col1">
			<?php 

				foreach ($event['Brackets'][5] as $k => $v): 
				if($k>7) continue;

			?>	
				<?php //print_r($v); die(); ?>
				<?php echo $this->element("match",array("match"=>$v,"bracket"=>5)); ?>
			<?php endforeach ?>
		</div>
			<div class="col col2">
				<?php 

					foreach ($event['Brackets'][5] as $k => $v): 
					if($k<8) continue;

				?>	
					<?php //print_r($v); die(); ?>
					<?php echo $this->element("match",array("match"=>$v,"bracket"=>5)); ?>
				<?php endforeach ?>
			</div>

		<!-- Bracket 4 -->
		<div class="col col3">
			<?php 
				foreach ($event['Brackets'][4] as $k => $v): 
				if($k>3) continue;
			?>
				<?php echo $this->element("match",array("match"=>$v,"bracket"=>4)); ?>
			<?php endforeach ?>
		</div>
		<div class="col col4">
			<?php 
				foreach ($event['Brackets'][4] as $k => $v): 
				if($k<4) continue;
			?>
				<?php echo $this->element("match",array("match"=>$v,"bracket"=>4)); ?>
			<?php endforeach ?>
		</div>

		<!-- Bracket 3 -->
		<div class="col col5">
			<?php 
				foreach ($event['Brackets'][3] as $k => $v): 
				if($k>1) continue;
			?>
				<?php echo $this->element("match",array("match"=>$v,"bracket"=>4)); ?>
			<?php endforeach ?>
		</div>
		<div class="col col6">
			<?php 
				foreach ($event['Brackets'][3] as $k => $v): 
				if($k<2) continue;
			?>
				<?php echo $this->element("match",array("match"=>$v,"bracket"=>4)); ?>
			<?php endforeach ?>
		</div>

		<!-- Bracket 2 -->
		<div class="col col7">
			<?php 
				foreach ($event['Brackets'][2] as $k => $v): 
				if($k>0) continue;
			?>
				<?php echo $this->element("match",array("match"=>$v,"bracket"=>4)); ?>
			<?php endforeach ?>
		</div>
		<div class="col col8">
			<?php 
				foreach ($event['Brackets'][2] as $k => $v): 
				if($k<1) continue;
			?>
				<?php echo $this->element("match",array("match"=>$v,"bracket"=>4)); ?>
			<?php endforeach ?>
		</div>

		<!-- Bracket 1 -->

		<div class="col col9">
			<?php 
				foreach ($event['Brackets'][1] as $k => $v): 
				
			?>
				<?php echo $this->element("match",array("match"=>$v,"bracket"=>4)); ?>
			<?php endforeach ?>
		</div>
	</div>
</div>
<div class="voting-div">
	<div class="inner">
		<div class="rules clearfix">
			<div class="left">
				<img src="/theme/battle-at-the-berrics-6/img/rules-heading.png" alt="">
				<div style='float:left'>
					<ul>
						<li>Place your predictions on the two upcoming battles listed below.</li>
						<li>Your prediction will be saved and your score will be calculated at the end of each battle.</li>
						<li>Whomever has the highest weekly score will win a $25 Gift Certificate from LRG. </li>
						<li>Whomever has the most points at the end of BATB6 will win top secret prize package courtesy of LRG, a year’s supply of DC Shoes, and all expense paid trip to BATB7 Finals.. </li>
						<li>In the case of a tie, first place names will be entered and winner will be randomly selected.  </li>
						
					</ul>
				</div>
				<div style="float:right;">
					Scoring Table
							<table>
								<tr>
									<td>Ro-Sham-Bo</td>
									<td>1 Point</td>
								</tr>
								<tr>
									<td>Winner</td>
									<td>10 Points</td>
								</tr>
								<tr>
									<td>Winning Letters</td>
									<td>15 Points</td>
								</tr>
							</table>
				</div>
			</div>
			<div class="right">
				<script type='text/javascript'>
				var ord = window.ord || Math.floor(Math.random() * 1e16);
			  document.write('<script type="text/javascript" src="http://ad.doubleclick.net/N5885/adj/batb5_dailyops;sz=300x250;ord=' + ord + '?"><\/script>');
			</script>
			</div>
		</div>
		<div class="voting clearfix">
			<?php echo $this->element('voting-box',array("match"=>$featured[0],"match_num"=>1)); ?>
			<?php echo $this->element('voting-box',array("match"=>$featured[1],"match_num"=>2)); ?>
		</div>
	</div>
</div>
<div class="additional clearfix">
	<div class="battles">
		<div class="heading">
			Battle Videos
		</div>
		<div class="thumb-collection">
			<?php foreach ($event['Brackets'] as $bracket): ?>
				<?php foreach ($bracket as $match): if(empty($match['BatbMatch']['battle_dailyop_id'])) continue; ?>
					<?php if (!empty($match['BatbMatch']['pregame_dailyop_id'])): ?>
						  	<?php echo $this->element("dailyops/thumbs/standard-post-thumb",array("post"=>$match['PreGamePost'])) ?>
					<?php endif; ?>
					<?php echo $this->element("dailyops/thumbs/standard-post-thumb",array("post"=>$match['BattlePost'])) ?>
				<?php endforeach ?>
			<?php endforeach ?>
		</div>
	</div>
	<div class="scores clearfix">
		<div class="heading">
			BATB VI Leaderboard Presented By LRG Clothing
		</div>
		<div class="my-score-btn">
			<a href='/battle-at-the-berrics-6/my_scorecard'>CLICK HERE TO VIEW YOUR SCORECARD</a>
		</div>
		<div class="inner">
			<div class="weekly"></div>
			<div class="overall"></div>
		</div>
	</div>
</div>
