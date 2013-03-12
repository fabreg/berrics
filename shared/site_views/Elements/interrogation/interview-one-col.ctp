<div class="interview-one-col interrogation-block">
	<div class="row-fluid">
		<?php if (strtolower($item['placement'])!='right'): ?>
		<div class="span9">
			<img src="//img.theberrics.com/images/<?php echo $item['MediaFile']['file']; ?>" alt="">
		</div>
		<?php endif ?>
		<div class="span3 <?php echo $item['placement'] ?>" style=''>
			<p><?php echo nl2br($item['text_content']); ?></p>
		</div>
		<?php if (strtolower($item['placement'])=='right'): ?>
		<div class="span9">
			<img src="//img.theberrics.com/images/<?php echo $item['MediaFile']['file']; ?>" alt="">
		</div>
		<?php endif ?>
	</div>
</div>