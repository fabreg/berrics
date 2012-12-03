<?php 
	$TrendingPost = ClassRegistry::init("TrendingPost");

	$post = $TrendingPost->featuredPost();

	

?>
<div class="row-fluid">
	<div class="span12">
		<?php echo $this->element('dailyops/posts/featured/post',array("post"=>$post)); ?>
	</div>
</div>