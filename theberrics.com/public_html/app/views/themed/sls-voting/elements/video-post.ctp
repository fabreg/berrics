<div class='sls-video-post'>
	<?php echo $this->element("dailyops/post-bit",array("dop"=>$post)); ?>
	<?php if($this->params['isAjax']): ?>
	<div style='background-color:#000; height:30px;'></div>
	<?php endif; ?>
</div>