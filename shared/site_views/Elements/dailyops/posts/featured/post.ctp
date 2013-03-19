<?php $post['Dailyop']['post_template'] = "large"; ?>
<div class="row-fluid featured-post-div">
	<div class="span12">
		<div class="post featured-post clearfix">
			<?php
				$one = true;
				 if ($one): ?>
				<a href='/primitive-pain-is-beauty'><?php echo $this->Media->mediaThumb(array(
					"MediaFile"=>$post['DailyopMediaItem'][0],
					"w"=>1070
				)); ?>
			</a>
			<?php else: ?>
				
			<?php endif ?>
			<?php echo $this->element("dailyops/posts/post-top",array("dop"=>$post)); ?>
			<div class="post-media">
				<?php echo $this->Berrics->postMediaDiv($post,array("lazy"=>false)); ?>
			</div>	
			<?php echo $this->element("dailyops/posts/post-footer",array("dop"=>$post)); ?>
		</div>
		
	</div>
</div>