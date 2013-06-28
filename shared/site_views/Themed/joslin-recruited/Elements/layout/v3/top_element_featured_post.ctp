<?php 

	echo $this->Html->css(array("bn-dailyops"),null,array('inline'=>true));
	
	$Dailyop = ClassRegistry::init("Dailyop");

	$post = $Dailyop->returnPost(array("Dailyop.id"=>7249),1);


?>
<div class="row-fluid">
	
	<div class="span12" id='bc-post'>
		<div class="bc-post-title">
			CHRIS JOSLIN RECRUITED
		</div>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
</div>