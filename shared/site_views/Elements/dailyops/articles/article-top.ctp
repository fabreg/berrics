<div class="article-top">
		<h1><?php echo $post['Dailyop']['name']; ?></h1>
		<strong>Posted By:</strong>	<?php echo $post['User']['first_name']; ?> <?php echo $post['User']['last_name']; ?> | <?php echo date("M d, Y",strtotime($post['Dailyop']['publish_date'])); ?>
		<div class="tags">
			TAGS//
		</div>
	</div>