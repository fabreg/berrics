<?php $post['Dailyop']['post_template'] = "large"; ?>
<div class="row-fluid featured-post-div">
	<div class="span12">
		<div class="post featured-post clearfix">
			<?php
				$one = true;

				 if ($one): ?>
				<div style="text-align:center">
					<a href='/canteen/item/dave-swift-shoot-all-skaters-dave-swift.html'>
						<img src='//img.theberrics.com/images/77b109bd008b57db81ac677c75b5d5da.jpg' border='0' />
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