<div id='crew-roster-bits'>
	<div class='heading'>
		<img src='/theme/younited-nations-3/img/crew-roster-heading.jpg' border='0' alt='' />
	</div>
	<div class='roster-form-bits'>
		<?php for($i=1; $i<=10; $i++): ?>
		<?php echo $this->element("younited-nations-3/roster-form-bit",compact("i")); ?>
		<?php endfor; ?>
		<div style='clear:both;'></div>
	</div>
</div>