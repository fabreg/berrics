<div class="thumb-collection clearfix">
	<?php foreach ($posts as $k => $v): ?>
		<?php echo $this->element("dailyops/thumbs/standard-post-thumb",array("post"=>$v)); ?>
	<?php endforeach ?>
</div>