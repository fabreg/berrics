<div class="post-text">
	<div class="text-content">
		<p>
			<?php echo $dop['Dailyop']['text_content']; ?>
		</p>
	</div>
	<?php if (!empty($dop['Dailyop']['html_content'])): ?>
		<div class="html-content">
			<?php echo $dop['Dailyop']['html_content']; ?>
		</div>
	<?php endif; ?>
</div>