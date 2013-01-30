<div id='crew-roster-bits'>
	<div class='heading'>
		<img src='/theme/younited-nations-3/img/crew-roster-heading.jpg' border='0' alt='' />
	</div>
	<div class='form-help'>
	* The Members of your crew and their affiliation. <br />* You may add up to 10 members. <br />* You can update your crew anytime during the contest
	</div>
	<div class='roster-form-bits'>
		<?php for($i=0; $i<=9; $i++): ?>
		<?php echo $this->element("younited-nations-3/roster-form-bit",compact("i")); ?>
		<?php endfor; ?>
		<div style='clear:both;'></div>
	</div>
	<div class='submit-holder'></div>
</div>