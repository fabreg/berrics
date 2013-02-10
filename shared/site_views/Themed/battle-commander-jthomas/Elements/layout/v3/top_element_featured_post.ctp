<?php 

	echo $this->Html->css(array("jt-dailyops"),null,array('inline'=>true));
	
	$Dailyop = ClassRegistry::init("Dailyop");

	$post = $Dailyop->returnPost(array("Dailyop.id"=>6600),1);


?>
<div class="row-fluid">
	<div class="span2 hidden-phone">
		<a href='/canteen/item/zero-skateboards-battle-commander-jamie-thomas-mini.html'>
			<img src="/theme/battle-commander-jthomas/img/deck-left.png" alt="" border='0' />
		</a>
	</div>
	<div class="span8" id='bc-post'>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
	<div class="span2 hidden-phone">
		<a href='/canteen/item/zero-skateboards-battle-commander-jamie-thomas.html'>
			<img src="/theme/battle-commander-jthomas/img/deck-right.png" alt="" border='0' />
		</a>
	</div>
</div>