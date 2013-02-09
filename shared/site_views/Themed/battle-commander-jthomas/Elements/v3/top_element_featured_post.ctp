<?php 
	$TrendingPost = ClassRegistry::init("TrendingPost");

	$post = $TrendingPost->featuredPost();

?>
<?php if (isset($post['Dailyop']['id'])): ?>
<div class="row-fluid">
	<div class="span2">
		<a>
			<img src="/theme/battle-commander-jthomas/deck-left.png" alt="" border='0' />
		</a>
	</div>
	<div class="span8">
		
	</div>
	<div class="span2">
		<a>
			<img src="/theme/battle-commander-jthomas/deck-right.png" alt="" border='0' />
		</a>
	</div>
</div>
<?php endif; ?>