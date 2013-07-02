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
	<div class="span8" id='post'>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
	<div class="span2 hidden-phone">
		
	</div>
</div>