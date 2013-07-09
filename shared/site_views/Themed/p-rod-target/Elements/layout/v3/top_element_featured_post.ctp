<script>
	jQuery(document).ready(function($) {
		


	});
</script>
<?php 

	echo $this->Html->css(array("dailyops"),null,array('inline'=>true));
	
	$Dailyop = ClassRegistry::init("Dailyop");

	$post = $Dailyop->returnPost(array("Dailyop.id"=>7256),1);


?>
<div class="row-fluid" id='chima'>
	<div class="span2 hidden-phone">
		
	</div>
	<div class="span8" id='post' style='text-align:center;'>
		<a href='http://www.youtube.com/watch_popup?v=0GhggY-kHRI' target='_blank'>
			<img src="/theme/p-rod-target/img/play-tile.png" alt="">
		</a>
	</div>
	<div class="span2 hidden-phone">
		
	</div>
</div>