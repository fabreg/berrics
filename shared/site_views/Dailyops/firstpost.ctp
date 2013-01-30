<div id='section-view-header'>
	<?php 
	
		echo $this->element("dailyops/section-header");
	
	?>
</div>
<?php 

$this->Html->script("dailyops/post-bit",array("inline"=>false));

$title_for_layout = $section['name']." ".$year;

$this->set(compact("title_for_layout"));

?>
<style>
#thumbs .left {
	
	float:left;	
	margin-bottom:8px;
}
#thumbs .right {

	float:right;
	margin-bottom:8px;
}

</style>
<div>
	<?php 
	
	
		echo $this->element("dailyops/post-bit",array("dop"=>$first_post));
	
	
	?>
</div>
<?php 

echo $this->element("dailyops/section-year-menu");

?>
<div id='section-view'>
	
	<?php 
	
		foreach($posts as $key=>$month):
	
	?>
	<div class='month'>
		<div class='title'>
			<!-- <h2><?php echo strtoupper($key); ?> <?php echo $year; ?></h2> -->
			<?php 
			
				echo $this->Berrics->monthYearHeader($year."-".$key."-01 00:00:00");
				
			?>
			
		</div>
		<div>
			<?php 
				$month = array_reverse($month);
				foreach($month as $post):
			
			?>
				<?php 
				
					echo $this->element("dailyops/post-thumb-med",array("dop"=>$post));
				
				?>
			<?php 	
			
			
				endforeach;
			
			?>
			<div style='clear:both;'></div>
		</div>
	</div>
	<?php 
	
		endforeach;
	
	?>
</div>
<?php 

echo $this->element("dailyops/section-year-menu");

?>
<?php

	echo pr($posts);

?>