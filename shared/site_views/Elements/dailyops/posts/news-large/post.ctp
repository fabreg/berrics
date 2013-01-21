<?php 

	$url = $this->Berrics->dailyopsPostUrl($post);

	$mediaFile = $post['DailyopTextItem'][0]['MediaFile'];

?>
<div class="post news-large">
	<?php echo $this->element("dailyops/posts/post-top",array("dop"=>$post)); ?>
	<?php echo $this->Berrics->postMediaDiv($post,array(
		"link"=>array(
			"href"=>$url,
			"target"=>""
		),
		"MediaFile"=>$mediaFile
	)) ?>
	<?php if (!empty($post['DailyopTextItem'][0]['text_content'])): ?>
	<div class="post-text">
		<div class="text-content">
			<p>
				<?php echo $post['DailyopTextItem'][0]['text_content']; ?>
			</p>
		</div>
	</div>
	<?php endif; ?>
	<?php echo $this->element("dailyops/posts/post-footer",array("dop"=>$post)); ?>
</div>