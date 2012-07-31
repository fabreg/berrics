<div class='index'>
	<h2>
		Event: <?php echo $mediahuntEvent['MediahuntEvent']['name']; ?>
	</h2>
	<div>
		<ul class='actions'>
			<li>
				<a href='/mediahunt_tasks/add/callback:<?php echo base64_encode($this->here); ?>'>Add New Task</a>
			</li>
		</ul>
		<div style='clear:both;'></div>
	</div>
	<div>
		<div style='float:left; width:33%;'>
			<h3>Tasks</h3>
			<div></div>
		</div>
		<div style='float:left; width:33%;'>	
			<h3>Recently Submitted</h3>
		</div>
		<div style='float:left; width:33%'>
			<h3></h3>
		</div>
		<div style='clear:both'></div>
	</div>
</div>