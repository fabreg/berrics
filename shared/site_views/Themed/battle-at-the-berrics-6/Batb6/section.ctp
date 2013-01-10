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

	});
	
</script>
<div class="top-header clearfix">
	<div class='top-dc-flag'>
		<img src="/theme/battle-at-the-berrics-6/img/dc-top-flag.png" alt="DC Shoes" />
	</div>
	<div class="top-banner">
		
	</div>
	<div class="top-lrg-logo">
		<img src="/theme/battle-at-the-berrics-6/img/lrg-top-logo.png" alt="LRG Clothing" />
	</div>
</div>
<div class="main-logo">
	<img src="/theme/battle-at-the-berrics-6/img/batb6-top-logo.png" alt="" />
</div>
<div class="post-view">

</div>
<div class="bracket-div">
	<div class="shim"></div>
	<div class="bracket">
		<div class="col col1">
			<!-- BRACKET 5 MATCH 0 > 7 -->
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
				foreach ($event['Brackets'][4] as $k => $v): 
				if($k>3) continue;
			?>
				<?php echo $this->element("match",array("match"=>$v,"bracket"=>4)); ?>
			<?php endforeach ?>
		</div>
		<div class="col col3">
			<?php 
				foreach ($event['Brackets'][3] as $k => $v): 
				if($k>1) continue;
			?>
				<?php echo $this->element("match",array("match"=>$v,"bracket"=>4)); ?>
			<?php endforeach ?>
		</div>
		<div class="col col4">
			<?php 
				foreach ($event['Brackets'][2] as $k => $v): 
				if($k>0) continue;
			?>
				<?php echo $this->element("match",array("match"=>$v,"bracket"=>4)); ?>
			<?php endforeach ?>
		</div>
		<div class="col col5">
			<?php 
				foreach ($event['Brackets'][1] as $k => $v): 
				
			?>
				<?php echo $this->element("match",array("match"=>$v,"bracket"=>4)); ?>
			<?php endforeach ?>
		</div>
		<div class="col col6">
			<?php 
				foreach ($event['Brackets'][2] as $k => $v): 
				if($k<1) continue;
			?>
				<?php echo $this->element("match",array("match"=>$v,"bracket"=>4)); ?>
			<?php endforeach ?>
		</div>
		<div class="col col7">
			<?php 
				foreach ($event['Brackets'][3] as $k => $v): 
				if($k<2) continue;
			?>
				<?php echo $this->element("match",array("match"=>$v,"bracket"=>4)); ?>
			<?php endforeach ?>
		</div>
		<div class="col col8">
			<?php 
				foreach ($event['Brackets'][4] as $k => $v): 
				if($k<4) continue;
			?>
				<?php echo $this->element("match",array("match"=>$v,"bracket"=>4)); ?>
			<?php endforeach ?>
		</div>
		<div class="col col9">
			<?php 

				foreach ($event['Brackets'][5] as $k => $v): 
				if($k<8) continue;

			?>	
				<?php //print_r($v); die(); ?>
				<?php echo $this->element("match",array("match"=>$v,"bracket"=>5)); ?>
			<?php endforeach ?>
		</div>
	</div>
</div>
<div class="voting-div">
	<div class="inner">
		<div class="rules clearfix">
			<div class="left">
				<img src="/theme/battle-at-the-berrics-6/img/rules-heading.png" alt="">
				<div>
					<ul>
						<li>Place your predictions on the two upcoming battles listed below.</li>
						<li>Your prediction will be saved and your score will be calculated at the end of each battle.</li>
						<li>Scoring is as follows...</li>
						<li>Whomever has the highest weekly score will win a $25 Gift Certificate from LRG. </li>
						<li>Whomever has the most points at the end of BATB6 will win top secret prize package courtesy of LRG, <br />a year’s supply of DC Shoes, and all expense paid trip to BATB7 Finals.. </li>
						<li>In the case of a tie, first place names will be entered and winner will be randomly selected.  </li>
					</ul>
				</div>
			</div>
			<div class="right"></div>
		</div>
	</div>
</div>
<pre>
<?php //print_r($event) ?>
</pre>
<?php 

print_r($event['Brackets'][5]);

 ?>