<?php 

	$this->set("title_for_layout","The Berrics - News");

?>
<div id="news-section">
	<div class="content">
		<?php foreach ($posts as $k => $v): ?>
			<?php echo $this->element("dailyops/posts/news/post",array("post"=>$v)); ?>
		<?php endforeach ?>
	</div>
	<div class="load-more-posts">
		
	</div>
</div>