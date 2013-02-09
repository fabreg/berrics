<?php 

	echo $this->Html->css(array("jt-dailyops"),null,array('inline'=>true));
	
	$TrendingPost = ClassRegistry::init("TrendingPost");

	$post = $TrendingPost->featuredPost();

?>

<div class="row-fluid">
	<div class="span2">
		<a>
			<img src="/theme/battle-commander-jthomas/img/deck-left.png" alt="" border='0' />
		</a>
	</div>
	<div class="span8">
		
	</div>
	<div class="span2">
		<a>
			<img src="/theme/battle-commander-jthomas/img/deck-right.png" alt="" border='0' />
		</a>
	</div>
</div>