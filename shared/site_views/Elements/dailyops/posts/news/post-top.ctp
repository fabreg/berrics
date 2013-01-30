<div class="post-top clearfix">
	<div class="date">
		<a href='<?php echo date("/Y/m/d",strtotime($post['Dailyop']['publish_date'])); ?>'><?php echo date("m-d-Y",strtotime($post['Dailyop']['publish_date'])) ?></a>
	</div>
	<div class="time">
		<?php echo date("h:i A",strtotime($post['Dailyop']['publish_date'])) ?>
	</div>
</div>