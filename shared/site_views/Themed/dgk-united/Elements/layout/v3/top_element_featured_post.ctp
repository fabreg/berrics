<?php 

	echo $this->Html->css(array("jt-dailyops"),null,array('inline'=>true));
	
	$Dailyop = ClassRegistry::init("Dailyop");

	$post = $Dailyop->returnPost(array("Dailyop.id"=>7381),1);


?>
<div class="row-fluid">
	<div class="span2 hidden-phone">
		<a href='/canteen/item/dgk-skateboards-dgk-united-nations.html'>
			<img src="/theme/dgk-united/img/deck-top.png" alt="" border='0' />
			<div>
				<img src='/theme/dgk-united/img/dgk-text-top_02.png' border='0' />
			</div>
		</a>
	</div>
	<div class="span8" id='bc-post'>
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	</div>
	<div class="span2 hidden-phone">
		<a href='/canteen/item/dgk-skateboards-dgk-united-nations.html'>
			<img src="/theme/dgk-united/img/dgk-deck-bottom.png" alt="" border='0' />
			<div>
				<img src='/theme/dgk-united/img/dgk-text-bottom_02.png' border='0' />
			</div>
		</a>
	</div>
</div>