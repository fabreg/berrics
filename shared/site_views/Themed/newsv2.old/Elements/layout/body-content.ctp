<div>
	<?php if($_SERVER['SCRIPT_URL'] == "/"): ?>
			<style type="text/css">
				#header,#header-container {

					display: none;
				}
			</style>
			<div class='enter-the-berrics'>
				<a href='/dailyops'>
				<img style='padding-top:8px;' border='0' alt='' src='/img/layout/newsv2/enter-button-bottom.jpg' />
				</a>
			</div>
		<?php endif; ?>
	<?php echo $content_for_layout; ?>
</div>