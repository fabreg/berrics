<?php $post['Dailyop']['post_template'] = "large"; ?>
<div class="row-fluid featured-post-div">
	<div class="span12">
		<div class="post featured-post clearfix">
			<?php
				$one = false;
				 if ($one): ?>
				<div style="text-align:center">
					<a href='/primitive-pain-is-beauty'>
						<?php echo $this->Media->mediaThumb(array(
													"MediaFile"=>$post['DailyopMediaItem'][0]['MediaFile'],
													"w"=>1070,
													"type"=>"large"
												)); ?>
					</a>
				</div>
			<?php else: ?>
				<?php echo $this->element("dailyops/posts/post-top",array("dop"=>$post)); ?>
				<div class="post-media">
					<?php echo $this->Berrics->postMediaDiv($post,array("lazy"=>false)); ?>
				</div>	
				<?php echo $this->element("dailyops/posts/post-footer",array("dop"=>$post)); ?>
			<?php endif ?>
			
		</div>
		
	</div>
</div>