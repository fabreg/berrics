<script>
	jQuery(document).ready(function($) {
		


	});
</script>
<?php 

	echo $this->Html->css(array("dailyops"),null,array('inline'=>true));
	
	$Dailyop = ClassRegistry::init("Dailyop");

	$post = $Dailyop->returnPost(array("Dailyop.id"=>6788),1);


?>
<div class="row-fluid">
	<div class="top">
		
	</div>
	<div id="post">
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
	<div class="bottom">
		
	</div>
</div>