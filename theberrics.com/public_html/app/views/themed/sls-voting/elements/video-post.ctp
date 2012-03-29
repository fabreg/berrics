<div class='sls-video-post'>
	<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	<?php if($this->params['isAjax']): ?>
	<div style='background-color:#000; min-height:30px;'>
	
		<a href='javascript:SlsVideo.closeVideo();'> [x] Close Video [x]</a>
	</div>
	
	<?php endif; ?>
</div>