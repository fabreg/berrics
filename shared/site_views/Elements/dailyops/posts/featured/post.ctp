<?php $post['Dailyop']['post_template'] = "large"; ?>
<div class="row-fluid featured-post-div">
	<div class="span12">
		<div class="post featured-post clearfix">
			<?php echo $this->element("dailyops/posts/post-top",array("dop"=>$post)); ?>
			<div class="post-media">
				<?php echo $this->Berrics->postMediaDiv($post,array("lazy"=>false)); ?>
			</div>	
			<?php echo $this->element("dailyops/posts/post-footer",array("dop"=>$post)); ?>
		</div>
		
	</div>
</div>