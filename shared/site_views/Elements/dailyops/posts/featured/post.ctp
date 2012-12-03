<?php $post['Dailyop']['post_template'] = "large"; ?>
<div class="post featured-post clearfix">
	<div class="media">
		<?php echo $this->Berrics->postMediaDiv($post); ?>
	</div>
	<div class="social">
		<?php echo $this->element("dailyops/posts/post-footer",array("dop"=>$post)); ?>
	</div>
</div>