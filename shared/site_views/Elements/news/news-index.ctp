<?php 

	$date = date("Y-m-d",strtotime($posts[0]['Dailyop']['publish_date']));

?>
<div class='news-collection' data-date='<?php echo $date; ?>'>
	<?php foreach ($posts as $k => $v): ?>
			<?php echo $this->element("dailyops/posts/news/post",array("post"=>$v)); ?>
	<?php endforeach ?>
</div>
