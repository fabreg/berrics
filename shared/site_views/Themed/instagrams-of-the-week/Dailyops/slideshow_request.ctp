<div class="igotw-item">
	<div class="heading">
		<img src="/img/v3/layout/igotw-heading-img.jpg" alt="The Berrics" />
	</div>
	<div class="image-item">
		<?php echo $this->Media->mediaThumb(array(

			"MediaFile"=>$data[0]['MediaFile'],
			"w"=>700

		)); ?>
	</div>
	<div class="footer">
		
			  <div class="prev-link">
			  	<?php if (
					$this->request->params['paging']['DailyopMediaItem']['prevPage'] == 1 && $this->request->params['paging']['DailyopMediaItem']['page'] > 2
				): ?>
			  	<a href='javascript:handleSlideShow(<?php echo $data[0]['Dailyop']['id'] ?>,<?php echo ($this->request->params['paging']['DailyopMediaItem']['page']-1); ?>);'>
			  		<img src="/img/v3/layout/igotw-prev-arrow.jpg" alt="" border="0">
			  	</a>
			  	<?php endif; ?>
			  </div>
			  <div class="next-link">
			  	<?php if (
					$this->request->params['paging']['DailyopMediaItem']['nextPage'] == 1
				): ?>
			  	<a href='javascript:handleSlideShow(<?php echo $data[0]['Dailyop']['id'] ?>,<?php echo ($this->request->params['paging']['DailyopMediaItem']['page']+1); ?>);'>
			  		<img src="/img/v3/layout/igotw-next-arrow.jpg" alt="" border="0">
			  	</a>
			  	<?php endif; ?>
			  </div>	
		
		<div style="width:auto; margin:auto" >
			<img src="/img/v3/layout/igotw-footer-img.jpg" alt="">
		</div>
			

	</div>
</div>