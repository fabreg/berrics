<?php if (preg_match('/(\/dailyops)/',$_SERVER['REQUEST_URI'])): ?>
	<?php echo $this->element("layout/v3/two-column"); ?>
<?php else: ?>
<div class="row-fluid" >
	<div class="span12" id='batb6-body'>
		<?php echo $content_for_layout; ?>
	</div>
</div>
<?php endif; ?>
