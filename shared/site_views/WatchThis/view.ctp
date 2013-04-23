<div id="watch-this-view">
	<?php echo $this->element("banners/728") ?>
	<div class="parent-post-title">
		<h1><a href='<?php echo $this->Berrics->dailyopsPostUrl($posts['parent']); ?>'><?php echo $posts['parent']['Dailyop']['name']; ?></a></h1>
		<?php if (!empty($posts['parent']['Dailyop']['sub_title'])): ?>
		<h2><?php echo $posts['parent']['Dailyop']['sub_title'] ?></h2>		
		<?php endif ?>
		<h3><?php echo $this->Time->niceShort($posts['parent']['Dailyop']['publish_date']); ?></h3>
	</div>
	<?php if (count($posts['post'])): ?>
	<div id="post">
		<?php echo $this->element("dailyops/post-bit",array("dop"=>$posts['post'])); ?>
	</div>
	<?php endif ?>
	<div id="posts">
		<?php if (count($posts['posts']) > 0): ?>
			<?php foreach ($posts['posts'] as $k => $v): ?>
				<?php echo $this->element("dailyops/post-bit",array("dop"=>$v)) ?>
				<?php if ($k==1): ?><?php echo $this->element("banners/728",array("unit"=>"dopsv3_728b")); ?>
				<?php endif ?>
			<?php endforeach ?>
		<?php endif ?>
	</div>
	<?php echo $this->element("dailyops/posts/recent-related-posts",$posts['parent']); ?>
</div>