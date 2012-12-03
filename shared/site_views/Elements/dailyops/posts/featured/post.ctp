<?php $post['Dailyop']['post_template'] = "large"; ?>
<div class="post featured-post clearfix">
	<div class="row-fluid">
		<div class="span11">
			<div class="post-media">
				<?php echo $this->Berrics->postMediaDiv($post); ?>
			</div>
			
		</div>
		<div class="span1 ">
			<div class="social">
				<?php echo $this->element("dailyops/posts/post-footer",array("dop"=>$post)); ?>	
			</div>
			
		</div>
	</div>
</div>