<div class="article-top" >
		<h1><?php echo $post['Dailyop']['name']; ?></h1>
		<!-- <strong>Posted By:</strong>	<?php echo $post['User']['first_name']; ?> <?php echo $post['User']['last_name']; ?> | <strong>Date:</strong> <?php echo date("M d, Y",strtotime($post['Dailyop']['publish_date'])); ?> -->
		<?php echo $this->element("dailyops/posts/post-footer",array("dop"=>$post)) ?>
	
</div>