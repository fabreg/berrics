<?php 

$Dailyop = ClassRegistry::init("Dailyop");

$recent_posts = $Dailyop->getRecentPostsByPost($post);

$related_posts = $Dailyop->getRelatedItems($post);

?>
<div class="recent-related-posts">
	<h3>Recent <small>(<a href="/<?php echo $post['DailyopSection']['uri'] ?>"> View More </a>)</small> </h3>
	<div class="thumb-collection clearfix">
		<?php foreach ($recent_posts as $k => $v): ?>
			<?php echo $this->element("dailyops/thumbs/standard-post-thumb",array("post"=>$v)); ?>
		<?php endforeach ?>
	</div>
	<?php if (count($related_posts)>0): ?>
	<h3>Related</h3>
	<div class="thumb-collection clearfix">
		<?php foreach ($related_posts as $k => $v): ?>
			<?php echo $this->element("dailyops/thumbs/standard-post-thumb",array("post"=>$v)); ?>
		<?php endforeach ?>
	</div>
	<?php endif ?>

</div>