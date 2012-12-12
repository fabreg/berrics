<div class="post-top">
	<div class='date'>
		<a href='<?php echo date("/Y/m/d",strtotime($dop['Dailyop']['publish_date'])); ?>'><?php echo date("m-d-Y",strtotime($dop['Dailyop']['publish_date'])); ?></a>
	</div>
	<div class="time">
		<?php echo date("h:i A",strtotime($dop['Dailyop']['publish_date'])); ?>
	</div>
	<h1>
		<?php echo $this->Berrics->dailyopsPostLink($dop['Dailyop']['name'],$dop); ?>
	</h1>
	<h2>
		<?php echo $this->Berrics->dailyopsPostLink($dop['Dailyop']['sub_title'],$dop); ?>
	</h2>
</div>